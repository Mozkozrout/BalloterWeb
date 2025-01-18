import { defineStore } from 'pinia';
import { User, Institution } from 'components/models';

export const useAuthStore = defineStore('authStore', {
  state: () => ({
    authUser: null as User | null,
    authToken: localStorage.getItem('token'),
    institutionList: [] as Institution[],
    loading: false,
  }),
  getters: {
    user: (state) => state.authUser,
    token: (state) => state.authToken,
    institutions: (state) => state.institutionList,
    isLoading: (state) => state.loading,
  },
  actions: {
    //Logged in user fetching
    async getUser(): Promise<void> {
      this.loading = true;

      try {
        this.api.defaults.headers.common['Authorization'] = this.authToken;
        const response = await this.api.get('user');
        this.authUser = response.data;
      } catch {
        localStorage.clear();
        this.authUser = null;
        this.authToken = '';
        this.institutionList = [];

        this.loading = false;
      }

      this.loading = false;
    },

    //login function
    async login(email: string, password: string): Promise<boolean> {
      this.loading = true;

      try {
        const response = await this.api.post('login', {
          username: email,
          password: password,
        });

        this.authToken = response.data.api_token;
        localStorage.setItem('token', response.data.api_token);
      } catch {
        this.loading = false;
        return false;
      }

      this.loading = false;
      return true;
    },

    //logout function
    async logout(): Promise<boolean> {
      this.loading = true;

      try {
        await this.api.get('logout');
        localStorage.clear();
        this.authUser = null;
        this.authToken = '';
        this.institutionList = [];
      } catch {
        this.loading = false;
        return false;
      }

      this.loading = false;
      return true;
    },

    //register function
    async register(
      email: string,
      password: string,
      repassword: string
    ): Promise<boolean> {
      this.loading = true;

      try {
        await this.api.post('register', {
          username: email,
          password: password,
          password_confirmation: repassword,
        });
      } catch {
        this.loading = false;
        return false;
      }

      this.loading = false;
      return true;
    },

    //delete user account
    async delete(): Promise<boolean> {
      this.loading = true;

      if (this.user != null) {
        try {
          this.api.defaults.headers.common['Authorization'] = this.authToken;
          await this.api.delete('user/'.concat(this.user.id));
          localStorage.clear();
          this.authUser = null;
          this.authToken = '';
          this.institutionList = [];
        } catch {
          this.loading = false;
          return false;
        }

        this.loading = false;
        return true;
      }
      this.loading = false;
      return false;
    },

    //update or create Personal data
    async updateOrCreatePerson(
      name: string,
      surname: string,
      birthdate: string,
      institution: string,
      note: string,
      state: string,
      city: string,
      street: string,
      house_nmr: string,
      zip: string
    ): Promise<boolean> {
      this.loading = true;

      //helpin variables
      let addr,
        inst,
        birth = null;

      try {
        //Institution selection ID from name
        this.institutionList.forEach((inst) => {
          if (inst.name === institution) {
            institution = inst.id;
          }
        });

        if (
          //making address null if not completely filled
          !(
            state == '' ||
            city == '' ||
            street == '' ||
            house_nmr == '' ||
            zip == ''
          )
        ) {
          addr = {
            state: state,
            city: city,
            street: street,
            house_nmr: house_nmr,
            zip: zip,
          };
        }
        //nulling empty values that are foreign keys in the db
        if (birthdate != '') birth = birthdate;
        if (institution != '') inst = institution;
      } catch {}

      //create Person
      if (this.user != null && this.user.person == null) {
        try {
          this.api.defaults.headers.common['Authorization'] = this.authToken;
          await this.api.post('person', {
            name: name,
            surname: surname,
            birthdate: birth,
            institution: inst,
            note: note,
            address: addr,
          });
        } catch {
          this.loading = false;
          return false;
        }
        this.loading = false;
        return true;
      }

      //Update Person
      if (this.user != null && this.user.person != null) {
        try {
          this.api.defaults.headers.common['Authorization'] = this.authToken;
          await this.api.put('person/'.concat(this.user.person.id), {
            name: name,
            surname: surname,
            birthdate: birth,
            institution: inst,
            note: note,
            address: addr,
          });
        } catch {
          this.loading = false;
          return false;
        }
        this.loading = false;
        return true;
      }

      this.loading = false;
      return false;
    },

    async deletePerson(): Promise<boolean> {
      this.loading = true;

      if (this.user != null && this.user.person != null) {
        try {
          this.api.defaults.headers.common['Authorization'] = this.authToken;
          await this.api.delete('person/'.concat(this.user.person.id));
        } catch {
          this.loading = false;
          return false;
        }
        this.loading = false;
        return true;
      }
      this.loading = false;
      return false;
    },

    async getInstitutions(): Promise<boolean> {
      this.loading = true;

      try {
        this.api.defaults.headers.common['Authorization'] = this.authToken;
        const response = await this.api.get('institutions');
        response.data.forEach((institution: Institution) => {
          this.institutionList.push(institution);
        });
      } catch {
        this.loading = false;
        return false;
      }

      this.loading = false;
      return true;
    },
  },
});
