# M8. Programmeerimine:

**kodutöö** - Raamatupoe veebirakenduse ülesanne.
Eesmärgiks on luua lihtne PHP rakendus, mis teeb raamatupoe andmebaasi PDO abil päringuid.

## Rakenduse vajalik funktsionaalsus:

Raamatute nimekirja vaade, nimed linkidena, mis suunavad raamatu vaatesse.
Ühe raamatu vaade, mis näitab GET parameetri id abil konkreetse raamaatu andmeid baasist. Vajalik näidata vähemalt 7 omadust - seal hulgas pilti ja raamatu autoreid.

- Raamatu muutmise funktsioon.
- Vorm raamatu väljadega. Peab saama muuta pealkirja ja veel kolme välja.
- Autori eemaldamine raamatu küljest.
- Autori lisamine raamatu külge.
- Raamatu kustutamise nupp. - Muudab baasis raamatu tabelis is_deleted välja väärtuseks 1. Kui sellist veergu ei eksisteeri, siis vaja see kõigepealt tabelisse luua.
- Autori lisamine. Eesnime ja perenime väli. Lisab autori tabelisse. Link sellele funktsioonile avalehe päises.
- Otsinguväli. Võib valida, kas teha JS filter või PHP abil otsisõna abil teha päring baasi. Otsingu väli avalehe päises.
