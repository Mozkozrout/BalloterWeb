export default {
  //BOTA
  category: {
    content: {
      title: 'Obsah',
      analysis: {
        title: 'Analýza',
        high: 'Debatérka analyzuje otázky spojené s tezí do hloubky. Její analýza jde k podstatě problému a řeší principiální spory. Zná předpoklady, na kterých její argumentace stojí, a je schopna je vysvětlit.',
        midHigh:
          'Debatérka se snaží o podrobnější analýzu problémů s tezí spojených. Je schopna vést spor hodnot a navzájem je poměřit.',
        medium:
          'Debatérka vysvětluje svá tvrzení.Je schopna identifikovat principy, které s tezí souvisí, a jednoduše je vysvětlit. Do složitější analýzy nebo do hodnotových sporů se ale nepouští',
        midLow:
          'Debatérka se snaží svá tvrzení vysvětlit. Její vysvětlení jsou jednoduchá. Podrobnější rozbor problémů chybí.',
        low: 'Debatérka se omezuje na pouhá tvrzení. Výjimečně se pokusí své tvrzení vysvětlit.',
      },
      proving: {
        title: 'Dokazování',
        high: 'Téměř všechna debatérova tvrzení jsou podpořena důkazy. Důkazy jsou relevantní k danému tvrzení, pocházejí z důvěryhodných zdrojů, včetně zahraničních. Debatér důkazům rozumí a vysvětluje jejich význam.',
        midHigh:
          'Debatér používá důkazy, z nichž většina je relevatních pro dané tvrzení. Důkazy pocházejí převážně z důvěryhodných zdrojů, debatér jim rozumí.',
        medium:
          'Řeč je podpořena alespoň nějakými důkazy, mezi nimiž se objevují i důkazy irelevantní, případně s pochybnou důvěryhodností. Debatér ne vždy důkazům rozumí a ne vždy je dokáže vysvětlit.',
        midLow:
          'Debatér přednáší důkazů minimum; většina jeho tvrzení není nijak prokázána. Pokud se důkaz objeví, málokdy je relevantní nebo důvěryhodný.',
        low: 'Debatér svá tvrzení nedokazuje. (Úmyslné použití vymyšlených důkazů je porušením etického kodexu a sankcionuje se 50 body).',
      },
      impacts: {
        title: 'Dopady',
        high: 'Debatérka vysvětluje dopady všech svých tvrzení na platnost (obhajoby) teze;u návrhových a hodnotových tezí i na hodnotu, která je pro tezi podstatná. Vysvětlení jsou logická a obsahují všechny potřebné kroky.',
        midHigh:
          'Debatérka vysvěluje dopady svých tvrzení na platnost teze. Snaží se u návrhových tezí vysvětlit dopad na hodnoty; nedaří se jí to však u všech argumentů. Vysvětlením občas schází logické kroky.',
        medium:
          'Debatérka se snaží vysvětlovat dopady svých tvrzení. V některých případech však vysvětlení chybí, chybí mu logické kroky, nebo schází hodnota, ke které by argument měl směřovat.',
        midLow:
          'Debatérka zhruba ví, že by měla dopady uvádět, ale přesně neví jak. Výsledkem je, že dopad většinou chybí; je-li uveden, málokdy dává smysl. Stává se, že část argumentace pozici týmu vůbec nepodporuje.',
        low: 'Debatérka dopady nedovozuje; nevadí jí, že ani věcně argument s tezí nesouvisí.',
      },
      reactions: {
        title: 'Reakce',
        high: 'Debatér reaguje na všechna podstatná tvrzení, která v debatě zazněla. Jeho reakce jsou relevantní, přímo a jasně vyvracejí argumenty protistrany a zároveň rozvíjejí argumentaci vlastního týmu.',
        midHigh:
          'Debatér reaguje na všechna podstatná tvrzení, která v debatě zazněla. Podstatná většina reakcí je relevantních a (alespoň nepřímo) vyvrací argumenty protistrany. Debatér se snaží také rozvíjet argumentaci vlastního týmu.',
        medium:
          'Debatér reaguje na většinu podstatných tvrzení, některá však opomine a naopak se vyjadřuje i k nepodstatným věcem. Některé reakce nejsou relevantní. Debatér se někdy uchyluje jen k opakování toho, co řekl předchozí mluvčí jeho týmu.',
        midLow:
          'Debatér se snaží o reakce na tvrzení svého předřečníka, nicméně často podstatná tvrzení opomine a velkou část svého projevu věnuje nepodstatným věcem. Často jen opakuje to, co řekl předchozí mluvčí jeho týmu.',
        low: 'Debatér reaguje na tvrzení protistrany jen málo, většinou pouze opakuje, co již v debatě zaznělo. Pokud se reakce objeví, málokdy je relevantní.',
      },
    },
    strategy: {
      title: 'Strategie',
      structure: {
        title: 'Struktura',
        high: 'Řeč je naprosto jasná a přehledná. Debatér rozděluje svoji argumentaci do pevně uzavřených logických celků a v každém okamžiku je zcela jasné, k jakému bodu hovoří a proč danou věc říká. Argumentace samotná má zřejmý dopad, vyvracení je jasně navázáno na argumentaci druhého týmu.',
        midHigh:
          'Řeč má pevně danou strukturu a debatér je schopný se jí držet. Občasné vybočení ze struktury není nijak na újmu srozumitelnosti argumentace.',
        medium:
          'Debatér se snaží v řeči mít strukturu, ovšem ne vždy se mu to daří. Některé myšlenky opakuje na různých místech, či je špatně přiřadí k argumentačním celkům. Struktura jeho řeči mírně škodí srozumitelnosti a rozhodčí musí přemýšlet o tom, kam danou myšlenku zařadit.',
        midLow:
          'Debatér má řeč strukturovanou na větší celky, ovšem není schopný se jich držet. Skáče od jednoho bodu k druhému a často není jasné, proč říká danou věc. Argumentaci je z toho důvodu špatně rozumět a rozhodčí musí pracně spojovat vyslovené myšlenky s ostatním obsahem debaty',
        low: 'Řeč je nesourodou změtí myšlenek, které často nemají hlavu ani patu. Debatér říká, co ho zrovna napadne a je velmi těžké pochopit, proč to vlastně povídá.',
      },
      timeWork: {
        title: 'Práce s časem',
        high: 'Debatérka skončí svoji řeč úderem 6. (5.) minuty. V rámci řeči věnuje jednotlivým sporům tolik času, kolik zasluhují a stihne v klidu vysvětlit veškeré podstatné myšlenky.',
        midHigh:
          'Řeč trvá stanovenou dobu s možnými mírnými odchylkami (+/- 10 s). Debatérka stihne říct v řeči vše podstatné, i když některé argumenty by zasluhovaly více pozornosti a u jiných by mohla strávit méně času.',
        medium:
          'Debatérka více méně naplní časový limit (+/-30 vteřin) a zároveň většině sporů věnuje potřebný čas. Jeden z argumentů (sporů) však nestihne vysvětlit, či se k němu dostane až po řádném čase.',
        midLow:
          'Debatérka má problémy s dodržením časového limitu. Buď je řeč příliš dlouhá (více než 30 vteřin přes limit), nebo naopak výrazně nenaplní přidělený čas (o více, než minutu). Debatérka nevěnuje dostatek času sporům, které jsou pro debatu klíčové.',
        low: 'Řeč zcela nenaplňuje vymezený čas. Debatérka se věnuje klíčovým věcem pouze okrajově či vůbec.',
      },
      teamWork: {
        title: 'Týmová práce',
        high: 'Debatér je naprosto konzistentní se zbytekm týmu. Skvěle rozvíjí myšlenky svých předřečníků a dokáže velmi dobře využít informací z křížového výslechu.',
        midHigh:
          'Debatér se drží linie svého týmu a v jeho řeči nejsou žádné rozpory - ať už vnitřní, či s předřečníky. Zvládá pracovat s informacemi z KO a rozvíjet argumetaci (či shrnovat) svých předřečníků.',
        medium:
          'Debatér nemá ve své řeči zásadní rozpory s ostatními, ovšem občas přinese novou myšlenku, která do argumentace týmu nezapadá. Některé argumenty či podbody svých předřečníků naopak nechá plavat.',
        midLow:
          'Tato řeč je v poměrně vážném rozporu s ostatními mluvčími - buď si v podstatné otázce protiřečí s kolegy, nebo přináší zásadně novou argumentaci  tu starou vypouští.',
        low: 'Tato řeč nemá s ostatními členy týmu mnoho společného - řečník si prostě říká to svoje a nebere žádné ohledy na argumentaci týmu.',
      },
      roleFulfillment: {
        title: 'Naplnění role',
        high: 'Debatérka perfektně splnila svou úlohu v debatě a učinila vše, co se od něj čekalo. Její řeč byla klíčová pro vítězství v debatě.',
        midHigh:
          'Debatérka dobře zvládla svoji úlohu a v její řeči nebyly podstatné chyby. Jednalo se o velmi solidní řeč, která týmu výrazně prospěla.',
        medium:
          'Debatérka si svoji roli splnila, ovšem řeč měla určité nedostatky - např. opomenutí reagovat na méně podstatný argument či občasná argumentace v třetí řeči.',
        midLow:
          'Debatérka měla problém se svojí rolí v debatě. Jako A1 nepřinesla definice či podstatnou část argumentace, jako reakční řeč příliš nereagovala, jako trojka neshrnovala, nýbrž argumentovala či opakovala.',
        low: 'Debatérka zcela nezvládla svoji roli v debatě a tím svůj tým potopila.',
      },
    },
    style: {
      title: 'Styl',
      language: {
        title: 'Jazyk',
        high: 'Řeč je jazykově bohatá, debatér používá úderné a přesvědčivé formulace. Vždy najde to správné slovo, které vystihuje to, co chce říct. Nezaplňuje řeč zbytečnou "omáčkou" ale zároveň je celou dobu jasné, o čem mluví. Nestane se, že by si rozhodčí řekl "teď jsem se ztratil" či "není mi jasné, jestli s věcí XY souhlasí, či nikoliv".',
        midHigh:
          'Řeč je přehledná a působí přesvědčivě, má však některé drobné vady. Debatér sem tam použije nadbytečné slovo či obrat, některé myšlenky opakuje. Nebo naopak věci vysvětluje sice stručně, ale trošku nepřehledně.',
        medium:
          'Debatér používá trochu moc "omáčky", opakuje se, často používá floskule a prázdné fráze. Zbytečně často používá obraty jako "dámy a pánové" či "vlastně", nebo nežádoucí pauzy vyplňuje rušivým táhlým "eh". Někdy použije slovo, které v daném kontextu nedává úplně smysl. Větná stavba je místy příliš dlouhá a komplikovaná, což znesdnaňuje porozumění myšlence. Pokud se tyto chyby vyskytují současně, žádná z nich není extrémně výrazná. Pokud se debatér dopouští jen jedné z těchto chyb (například užívání výplňkových slov), pak musí být velmi intenzivní a rušivá.',
        midLow:
          'Debatér zjevně nemá širokou slovní zásobu, obtížně hledá slova, trvá mu dlouho, než se "vymáčkne". Používá mnoho výplňkových slov. Často není zcela jasné, co chtěla tou či onou větou říci, jeho souvětí nezřídka nemají jasný začátek a konec. Řeč nezní přesvědčivě.',
        low: 'Debatér jen s obtížemi vyjadřuje i základní myšlenky. Rozhodčímu trvá dlouho, než pochopí, co chce vlastně říct, a ne vždy se mu to podaří. Výplňková slova a zbytečná "vata" tvoří značnou část řeči.',
      },
      voice: {
        title: 'Hlas a dikce',
        high: 'Řeč je dynamická a zajímavá, neuspává. Debatérka dělá pauzy na správných místech, mluví dostatečně nahlas, jasně artikuluje. Řekne toho opravdu hodně, aniž by však rozhodčí měl pocit, že nestíhá sledovat a nad řečí přemýšlet.',
        midHigh:
          'Debatérka mluví zajímavě, ale v některých místech je její řeč trochu jednolitá a monotónní. Nebo je sice dynamická, ale místy jí není úplně jasně rozumět. Nebo netrpí žádným z předchozích nedostatků, ale kvůli vysoké rychlosti je místy nesnadné ji sledovat.',
        medium:
          'Debatérka se celkem často zadrhává, dělá pauzy na nesmyslných místech, občas docela dlouho přemýšlí co vlastně říct. Nebo je naopak její řeč dlouhým stejnorodým proudem slov. Plně se soustředit po celou dobu řeči vyžaduje od rozhodčího určité úsilí. Řeč však není neszrozumitelná, rozhodčí chápe, o čem debatérka mluví.',
        midLow:
          'Řeč je obtížné sledovat, není plynulá. Debatérka někdy mumlá a mluví příliš potichu, takže je obtížné jí rozumět. Nebo naopak řve, ale není jasné proč, pochopení obsahu řeči hlasitost nijak nenapomáhá.',
        low: 'Debatérka téměř neotvírá pusu, zadrhává se, je velmi těžké věnovat její řeči plnou pozornost. Často je jí špatně rozumět.',
      },
      gestures: {
        title: 'Gesta',
        high: 'Řeč vyvolává skvělý vizuální dojem - debatér používá jasná, dostatečně živá gesta, která rozhodčího nerozptylují, ale naopak mu umožňují lépe pochopit obsah projevu.',
        midHigh:
          'Debatérova gestikulace řeči pomáhá, ale v některá gesta nadužívá či rytmicky opakuje, což místy trochu ruší. Nebo je naopak trochu příliš strnulý. Nejedná se ale o nedostatky závažné a časté.',
        medium:
          'Debatér dělá vícero chyb méně intenzivně (např. se místy rytmicky houpe vpřed-vzad a jindy si zase rytmicky přesunuje poznámky z ruky do ruky), nebo jednu velmi výrazně (např. celou řeč drží oběma rukama desky a ani se npohne).',
        midLow:
          'Debatérova gestikulace trpí vícero významnými nedostatky, např. se neustále kýve vpřed-vzad, přešlapuje z nohy na nohu, hraje si s vlasy, hodinkami či tužkou či rušivě a nesmyslně mává rukama. Na jeho řeč není hezký pohled a gestikulace nepomáhá porozumět obsahu, rozhodčí by projevu rozumněl úplně stejně i z audiozáznamu.',
        low: 'Debatér dělá tolik chyb natolik výrazně, že jeho gestikulace projev poškozuje. Jeho gesta jsou natolik rušivá, že je obtížné věnovat pozornost obsahu řeči. Nebo je naopak strnulý jako socha, což působí velmi rušivě a věnovat se obsahu je náročné.',
      },
      eyeContact: {
        title: 'Oční kontakt a emoce',
        high: 'Debatérka skvěle zachovává oční kontakt - do publika se dívá v podstatě nepřetržitě. Emoce, které vyzařuje, vždy korespondují s obsahem řeči (lítost, spravedlivé rozhořčení atp.). Rozhočí celou dobu cítí, že debatérka se snaží přesvědčit jeho, nikoliv svého soupeře či zeď.',
        midHigh:
          'Debatérka se většinu času dívá na rozhodčí, ale tu a tam se přece jen příliš zadívá do svých poznámek či civí na soupeře. Nebo zachovává oční kontakt sice pořádně, ale jinak působí mírně nezúčastněně, jako by jí na jejích argumentech nezáleželo. Žádná z těchto chyb se ale nevyskytuje ve velké míře.',
        medium:
          'Debatérka se dívá na rozhodčího jen tak polovinu své řeči, zbytek času tráví její oči na poznámkách nebo na různých náhodných místech v místnosti. Svou řeč neprožívá, místy to vypadá, že není se svými argumenty zcela ztotožněná.',
        midLow:
          'Debatérka se většinu času dívá do papíru či na soupeře, na rozhodčího pohlédne zřídka. Působí vystrašeně nebo zcela nepřítomně, není jasné, jestli své argumenty pokaždé chápe, nebo jestli jí je jen někdo nadiktoval.',
        low: 'Debatérka se na rozhodčího vůbec nedívá, od papíru zvedne oči jen několikrát, a ato aby se podívala na soupeře nebo do rohu místnosti. Téměř celý projev čte z papíru a očividně většinu argumentace nechápe. V podstatě je duchem nepřítomná.',
      },
    },
    cq: {
      title: 'Křížový Výslech',
    },
  },
  tooltips: {
    close: 'Zavřít tuto nápovědu',
    content: {
      analysis:
        '(u třetích mluvčích se posuzuje analýza sporů, které v debatě zazněly)',
      proving: '(kategorie se nepoužije pro řeči třetích mluvčích)',
      reactions:
        '(kategorie se nepoužije pro řeč A1 a pro řeči třetích mluvčích)',
    },
    strategy: {
      structure:
        'Pokud je struktura řeči jasná, srozumitelná a dává v daném případě smysl, může se lišit od struktury předřečníků',
      timeWork:
        'Tato kategorie zahrnuje 2 kritéria - dodržení časového limitu a rozvržení času v řeči',
      teamWork:
        'Tato kategorie se příliš nepoužije u prvních mluvčích, zvláště A1 - tam budeme hodnotit, jak dobře připravili půdu pro ostatní.',
      roleFulfillment:
        'Zde je třeba posuzovat každou řeč podle své role- A1 má představit definice a argumentaci, N1, A2, N2 převážně reagovat a trojky shrnovat',
    },
  },
};
