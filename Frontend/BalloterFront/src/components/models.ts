export interface Todo {
  id: number;
  content: string;
}

export interface Meta {
  totalCount: number;
}

//Database Auth and Ballot Objects

export interface User {
  id: string;
  username: string;
  person: Person;
  admin: boolean;
  role: Role;
  api_token: string;
  preferred_locale: string;
  created_at: Date;
  updated_at: Date;
}

export interface Person {
  id: string;
  name: string;
  surname: string;
  birthdate: string;
  institution: Institution;
  id_number: string;
  address: Address;
  note: string;
  created_at: Date;
  updated_at: Date;
}

export interface Role {
  id: string;
  name: string;
  created_at: Date;
  updated_at: Date;
}

export interface Institution {
  id: string;
  name: string;
  short_name: string;
  address: Address;
  note: string;
  created_at: Date;
  updated_at: Date;
}

export interface Address {
  id: string;
  state: string;
  city: string;
  street: string;
  house_nmr: string;
  zip: string;
  created_at: Date;
  updated_at: Date;
}

export interface Motion {
  id: string;
  name: string;
  added_by: Person;
  edited_by: Person;
  created_at: Date;
  updated_at: Date;
}

export interface Ballot {
  id: string;
  tournament: Tournament;
  date: string;
  motion: Motion;
  team_AFF: Team;
  team_NEG: Team;
  decision: string;
  adj_winning_team: Team;
  winning_team: Team;
  adjucations: string;
  created_at: Date;
  updated_at: Date;
}

export interface Tournament {
  id: string;
  name: string;
  beggining: Date;
  end: Date;
  institution: Institution;
  note: string;
  created_at: Date;
  updated_at: Date;
}

export interface Team {
  id: string;
  name: string;
  institution: Institution;
  registered_by: User;
  team_members: Person[];
  events: Tournament[];
  created_at: Date;
  updated_at: Date;
}

export interface Speaker {
  id: string;
  ballot_id: number;
  person_id: Person;
  role: string;
  comment: string;
  cont_points: number;
  str_points: number;
  style_points: number;
  cq_points: number;
  best_speaker: number;
  author: number;
  created_at: Date;
  updated_at: Date;
}

export interface BallotData {
  Ballot: Ballot;
  People: Speaker[];
}

//Language Switcher component

export interface Language {
  en: string;
  native: string;
  short: string;
  flag: string;
}

//Bota View component

export interface CategoryResult {
  title: string[];
  rows: DataRow[][];
}

export interface DataRow {
  [key: string]: string;
}

export interface Result {
  points: number;
  category: number;
}

//BallotSpeaker component

export interface Sentence {
  category: string;
  content: string;
  subcontent: string;
}

//StopWatch component

export interface SpeachTime {
  title: string;
  limit: number;
  color: string;
}

export interface TimerData {
  limit: number;
  time: number;
  speach: string;
  color: string;
  running: boolean;
}

export interface BallotTimer {
  label: string;
  color: string;
  index: number;
}

export interface TimerList {
  APrep: number | null;
  NPrep: number | null;
  A1: number | null;
  A2: number | null;
  A3: number | null;
  N1: number | null;
  N2: number | null;
  N3: number | null;
  N3xA1: number | null;
  A3xN1: number | null;
  N1xA2: number | null;
  A1xN2: number | null;
}
