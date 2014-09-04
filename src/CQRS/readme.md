#Een lege interface voor commands en events

## Eigenschappen van commands en events
### Command
-  Het is een **data object**
- De naam geeft **intentie** weer (RegistreerGebruiker, VerwijderGebruiker)
- Het bevat **alle nodige informatie** (en zeker niet meer)

### Event
- Het is een **data object**
- De naam geeft aan dat iets gebeurd is **verleden**
- Het bevat wellicht minstens een id, je moet toch weten voor wie iets gebeurd is

### Conclusie:
- Ze hebben een welbepaald doel, en welbepaalde eigenschappen. Bigevolg hebben ze in alle waarschijnlijkheid reeds een base class of interface.

### Broadway is een CQRS systeem, alles draait om commands en events

Toch laat het systeem toe om alle mogelijke data types te versturen. Dat onder het motto leden niet te willen koppelen aan jullie code.

En zo is het mogelijk om
- Commands door event bussen te sturen
- Arrays, strings te verzenden door de bussen.

###Yup, we vertrouwen erop dat de gebruiker wel weet wat hij doet.
Ok... maar wat wint de gebruiker erbij als hij:
- Commands door event bussen stuurt zonder het te beseffen
- Denkt dat hij een commando verstuurd heeft maar eigenlijk is het een lege string. Doe je dat asynchronous dan krijg je wellicht nergens een foutmelding.

Heeft een gebruiker er niet meer baat bij dat het systeem dit NIET zou toelaten. Zouden jullie dit ooit voor jezelf zo coderen? Een messagebus die elke data toelaat. Je hoeft de gebruiker de optie niet te geven om een array door een messagebus te sturen. Je moet die gebruiker net laten weten dat dit niet zo hoort!

###Mijn voorstel: een lege interface Command en Event

interface Command{}
interface Event{}

Dit zorgt ervoor dat je
- Tenminste weet dat je met objecten werkt
- Tenminste weet dat de commandbus of eventbus wel degelijk een command of event heeft ontvangen
- Indien aan bovenstaande eisen niet is voldoen MOET een CQRS systeem onmiddelijk stoppen en dit gebeurt reeds in PHP (InvalidArgumentException)

### Extra werk voor de gebruiker
- Indien hij nog geen base class of interface had aangemaakt, dan zou hij dit beter doen (Ze delen eigenschappen)
- Indien wel dan abstractclass implements interface of, CommandInterface extends BroadwayCommand

Niet zoveel gevraagd toch. Ook al denkt men misschien in eerste instantie dat men dat liever toch inet zo heeft. Het lijkt me erg onverstandig dit niet te eisen.
Hoe kan je een betrouwbaar CQRS coderen als je de data die je als input krijgt niet valideert.
