
var LAST_NAME_ARRAY = 'ABCDEFGHIJKLMNOPRSTV';
var MIN_TIME        = 30;
var MAX_TIME        = 120;
var RADIUS          = 10;
var URL 			= 'http://www.hypercms.sk/geoip/';

var SK_CITY = [
	'Bratislava',
	'Žilina',
	'Prešov',
	'Košice',
	'Svidník',
	'Bardejov',
	'Humenné',
	'Michalovce',
	'Poprad',
	'Ružomberok',
	'Martin',
	'Dolný Kubín',
	'Námestovo',
	'Lučenec',
	'Zvolen',
	'Banská Bystrica',
	'Kremnica',
	'Púchov',
	'Čadca',
	'Prievidza',
	'Nitra',
	'Trnava',
	'Senica',
	'Skalica',
	'Myjava',
	'Komárno',
	'Malacky',
	'Štúrovo',
	'Šaľa',
	'Galanta',
	'Hlohovec',
	'Leopoldov',
	'Ilava',
	'Trenčín',
	'Bytča',
	'Rajec',
	'Turzovka',
	'Tvrdošín',
	'Trstená',
	'Stropkov',
	'Rožňava',
	'Gelnica',
	'Brezno',
	'Poltár',
	'Sliač',
	'Kežmarok',
	'Stará Ľubovňa',
	'Levoča',
	'Senec',
	'Topoľčany',
	'Zlaté Moravce',
	'Nové Zámky',
	'Šurany',
	'Šamorín',
];

var CZ_CITY = [
	'Praha',
	'Brno',
	'Ostrava',
	'Plzeň',
	'Liberec',
	'Karlovy Vary',
	'Kladno',
	'Písek',
	'Tábor',
	'České Budějovice',
	'Třebová',
	'Zlín',
	'Přerov',
	'Prostejov',
	'Karviná',
	'Havířov',
	'Znojmo',
	'Jihlava',
	'Mladá Boleslav',
	'Opava',
	'Třinec',
	'Český Těšín',
	'Olomouc',
	'Vyškov',
	'Frýdek-Místek',
];

var PL_CITY = [
	'Warsaw',
	'Krakow',
	'Katowice',
	'Tarnow',
	'Rzeszow',
	'Bialystok',
	'Lodz',
	'Poznan',
	'Wroclaw',
	'Szczecin',
	'Gdynia',
	'Gdansk',
	'Torun',
	'Lublin',
	'Nowy Sacz',
	'Przemysl',
	'Krosno',
	'Kielce',
];

var ES_CITY = [
	'Madrid',
	'Barcelona',
	'Valencia',
	'Seville',
	'Zaragoza',
	'Málaga',
	'Murcia',
	'Palma',
	'Las Palmas',
	'Bilbao',
	'Alicante',
	'Córdoba',
	'Valladolid',
	'Vigo',
	'Gijón',
	'Granada',
	'Elche',
];

var ES_FEMALE_NAME = [
	'Maria',
	'Laura',
	'Paula',
	'Marta',
	'Ana',
	'Andrea',
	'Sara',
	'Lucia',
	'Alba',
	'Marina',
	'Cristina',
	'Irene',
	'Carmen',
	'Natalia',
	'Elena',
	'Raquel',
	'Noelia',
	'Nerea',
	'Nuria',
	'Angela',
	'Inés',
	'Sandra',
	'Clara',
	'Eva',
	'Clàudia',
	'Celia',
	'Lorena',
	'Patricia',
	'Miriam',
	'Alicia',
	'Carla',
	'Silvia',
	'Julia',
	'Ainhoa',
	'Sofía',
	'Esther',
	'Isabel',
	'Rocío',
	'Beatriz',
	'Mireia',
	'Bea',
	'Fatima',
	'Luna',
	'Carolina',
	'Gloria',
	'Isa',
	'Sonia',
	'Mònica',
	'Verónica',
	'Ane',
	'Daniela',
	'Alejandra',
	'Aida',
	'Judith',
	'Tania',
	'Belen',
	'Lidia',
	'Aina',
	'Victoria',
	'Blanca',
	'Tamara',
	'Anna',
	'Diana',
	'Laia',
	'Judit',
	'Inma',
	'Alexandra',
	'Ariadna',
	'Naiara',
	'Paloma',
	'Yaiza',
	'Helena',
	'Almudena',
	'Pàola',
	'Uxue',
	'Emma',
	'Vanessa',
	'Mari',
	'Vicky',
	'Gema',
	'Leire',
	'Olga',
	'Ainoa',
	'Adriana',
	'Mery',
	'Irati',
	'Stella',
	'Mar',
	'Patri',
	'Rosa',
	'Nora',
	'Maite',
	'Ana María',
	'Jennifer',
	'Amanda',
	'Jessica',
	'Lara',
	'Anabel',
	'Aurora',
];

var ES_MALE_NAME = [
	'David',
	'Daniel',
	'Pablo',
	'Álvaro',
	'Adrian',
	'Alejandro',
	'Alex',
	'Javier',
	'Carlos',
	'Miguel',
	'Jose',
	'Sergio',
	'Antonio',
	'Jorge',
	'Ruben',
	'Juan',
	'Ivan',
	'Angel',
	'Raul',
	'Manuel',
	'Mario',
	'Dani',
	'Jesús',
	'Fran',
	'Diego',
	'Javi',
	'Pedro',
	'Victor',
	'Alberto',
	'Gonzalo',
	'Fernando',
	'Luis',
	'Andrés',
	'Francisco',
	'Cristian',
	'Iker',
	'Tomas',
	'Guillermo',
	'Samuel',
	'Enrique',
	'Óscar',
	'Martin',
	'Marcos',
	'Marc',
	'Paco',
	'Ismael',
	'Gorka',
	'Joan',
	'Jaime',
	'Asier',
	'Gabriel',
	'Miguel Angel',
	'Jose Manuel',
	'Guille',
	'Roberto',
	'Christian',
	'Sergi',
	'Albert',
	'Mohamed',
	'Paul',
	'Beñat',
	'Jose Luis',
	'Hugo',
	'Ignacio',
	'Juanma',
	'Juan Carlos',
	'Marco',
	'Domingo',
	'Pol',
	'Marcelo',
	'Lucas',
	'Bruno',
	'Manu',
	'Jon',
	'Pepe',
	'Arnau',
	'Joaquin',
	'Unai',
	'Aimar',
	'Kevin',
	'Ander',
	'Nacho',
	'Jose Miguel',
	'Eneko',
	'Santi',
	'Josep',
	'Rafael',
	'Borja',
	'Andy',
	'Nicolas',
	'Rafa',
	'Max',
	'Dario',
	'Julen',
	'Manolo',
	'Mateo',
	'Saul',
	'Toni',
	'Ibai',
	'Egoitz',
];

var PL_FEMALE_NAME = [
	'Kasia',
	'Karolina',
	'Ola',
	'Julia',
	'Aleksandra',
	'Marta',
	'Natalia',
	'Paulina',
	'Dominika',
	'Anna',
	'Klaudia',
	'Monika',
	'Kinga',
	'Magda',
	'Magdalena',
	'Ania',
	'Agnieszka',
	'Weronika',
	'Wiktoria',
	'Martyna',
	'Joanna',
	'Agata',
	'Alicja',
	'Ewa',
	'Maria',
	'Oliwia',
	'Patrycja',
	'Justyna',
	'Gosia',
	'Kamila',
	'Ada',
	'Sandra',
	'Dorota',
	'Izabela',
	'Paula',
	'Emilia',
	'Kate',
	'Zuzia',
	'Daria',
	'Sylwia',
	'Aneta',
	'Aga',
	'Maja',
	'Angelika',
	'Olga',
	'Zuza',
	'Amelia',
	'Zuzanna',
	'Victoria',
	'Michalina',
	'Sara',
	'Alexandra',
	'Ula',
	'Milena',
	'Asia',
	'Lena',
	'Iga',
	'Mary',
	'Marysia',
	'Agnes',
	'Basia',
	'Natalie',
	'Ela',
	'Katarzyna',
	'Urszula',
	'Wiola',
	'Gabi',
	'Marika',
	'Adrianna',
	'Marlena',
	'Hanna',
	'Ewelina',
	'Julka',
	'Sabina',
	'Roksana',
	'Sonia',
	'Ann',
	'Eliza',
	'Dagmara',
	'Aneta',
	'Zosia',
	'Edyta',
	'Emily',
	'Nina',
	'Iwona',
	'Angela',
	'Ala',
	'Renata',
	'Monica',
	'Judyta',
	'Bogna',
	'Jessica',
	'Barbara',
	'Kaja',
	'Tosia',
	'Karina',
	'Klocek',
	'Anastazja',
	'Alex',
	'Caroline',
];

var PL_MALE_NAME = [
	'Mateusz',
	'Szymon',
	'Bartek',
	'Patryk',
	'Kamil',
	'Marcin',
	'Michal',
	'Kuba',
	'Dawid',
	'Wojtek',
	'Tomek',
	'Adam',
	'Adrian',
	'Maciej',
	'Kacper',
	'Jakub',
	'Artur',
	'Pawel',
	'Dominik',
	'Przemek',
	'Bartosz',
	'Karol',
	'Krystian',
	'Piotr',
	'Sebastian',
	'Daniel',
	'Krzysztof',
	'Milosz',
	'Wiktor',
	'Lukasz',
	'Marcel',
	'Hubert',
	'Jacek',
	'Jan',
	'Grzegorz',
	'Wojciech',
	'Tomasz',
	'Arek',
	'Filip',
	'Damian',
	'Aleksander',
	'Marek',
	'Michael',
	'Martin',
	'Mikolaj',
	'David',
	'Łukasz',
	'Matthew',
	'Robert',
	'Paul',
	'Michal',
	'Chris',
	'Janek',
	'Darek',
	'Milosz',
	'Mikolaj',
	'Pawel',
	'Michał',
	'Oskar',
	'Peter',
	'Patrick',
	'Piotrek',
	'Maciek',
	'Norbert',
	'Bart',
	'Antek',
	'Daria',
	'Natalia',
	'Simon',
	'Stasiek',
	'Rafa',
	'Bartłomiej',
	'Lucas',
	'Matt',
	'Rem',
	'Julian',
	'Christopher',
	'Andrzej',
	'Lukasz',
	'Max',
	'Rafal',
	'Emil',
	'Kasia',
	'John',
	'Maurycy',
	'Casper',
	'Tymon',
	'Bartlomiej',
	'Pavel',
	'Krzysiek',
	'Kajtek',
	'Julia',
	'Alan',
	'Igor',
	'Mikołaj',
	'Martyn',
	'Ania',
	'Przemek',
	'Góba',
];

var CZ_FEMALE_NAME = [
	'Tereza',
	'Veronika',
	'Barbora',
	'Martina',
	'Lucie',
	'Karolina',
	'Adéla',
	'Jana',
	'Michaela',
	'Kristýna',
	'Klara',
	'Denisa',
	'Anna',
	'Eliška',
	'Markéta',
	'Lenka',
	'Hana',
	'Eva',
	'Petra',
	'Zuzana',
	'Monika',
	'Andrea',
	'Pavlina',
	'Kateřina',
	'Dominika',
	'Marie',
	'Kate',
	'Jitka',
	'Pavla',
	'Šárka',
	'Nikola',
	'Natálie',
	'Simona',
	'Radka',
	'Helena',
	'Zdenka',
	'Katka',
	'Zuzka',
	'Vendula',
	'Kateřina',
	'Nikol',
	'Hanka',
	'Aneta',
	'Bára',
	'Lucka',
	'Ivana',
	'Anet',
	'Míša',
	'Sára',
	'Paja',
	'Adriana',
	'Kamila',
	'Adel',
	'Věra',
	'Dana',
	'Sabina',
	'Barbara',
	'Ema',
	'Silvie',
	'Julie',
	'Johana',
	'Marta',
	'Adele',
	'Laura',
	'Silvia',
	'Sona',
	'Elizabeth',
	'Nela',
	'Natalia',
	'Alexandra',
	'Romana',
	'Anežka',
	'Teresa',
	'Daniela',
	'Tina',
	'Kateřina',
	'Kristína',
	'Dagmar',
];

var CZ_MALE_NAME = [
	'Martin',
	'Jakub',
	'Pavel',
	'Michal',
	'Ondřej',
	'David',
	'Jan',
	'Patrik',
	'Petr',
	'Honza',
	'Tomáš',
	'Lukas',
	'Marek',
	'Filip',
	'Karel',
	'Ondra',
	'Adam',
	'Dominik',
	'Tomas',
	'Radek',
	'Štìpán',
	'Lukáš',
	'John',
	'Michael',
	'Daniel',
	'Vojta',
	'Henry',
	'Peter',
	'Mates',
	'Tom',
	'Zdenìk',
	'Václav',
	'Aleš',
	'Richard',
	'Josef',
	'Zdenek',
	'Vladimir',
	'Robert',
	'Simon',
	'Oliver',
	'Jirka',
	'Michaela',
	'Vladan',
	'Jaroušek',
	'Alex',
	'Milan',
	'Samuel',
	'Rostislav',
	'Michel',
	'Dominik',
	'Mira',
	'Vítek',
	'Hanuš',
	'Matej',
	'Jiří',
	'Mirek',
	'Aleš',
	'Jarda',
	'Libor',
	'Ladislav',
];

var SK_FEMALE_NAME = [
	'Lenka',
	'Michaela',
	'Kristína',
	'Dominika',
	'Natalia',
	'Lucia',
	'Martina',
	'Katarina',
	'Veronika',
	'Andrea',
	'Barbora',
	'Simona',
	'Diana',
	'Adriana',
	'Jana',
	'Karin',
	'Sarah',
	'Sofia',
	'Nina',
	'Betka',
	'Monika',
	'Denisa',
	'Bianka',
	'Miriam',
	'Eva',
	'Petra',
	'Ivana',
	'Paula',
	'Hana',
	'Laura',
	'Katka',
	'Tatiana',
	'Lea',
	'Zuzana',
	'Mirka',
	'Erika',
	'Gréta',
	'Tinka',
	'Lada',
	'Simonka',
	'Simka',
	'Nikolka',
	'Mariannka',
	'Tereza',
	'Izabela',
	'Sabína',
	'Paulina',
	'Alica',
	'Radka',
	'Janka',
	'Nikola',
	'Ľudmila',
	'Klaudia',
	'Kika',
];

var SK_MALE_NAME = [
	'Martin',
	'Peter',
	'Adam',
	'Matej',
	'Lukáš',
	'Samuel',
	'Patrik',
	'Dávid',
	'Emil',
	'Marek',
	'Tomáš',
	'Pavol',
	'Filip',
	'Anton',
	'Michael',
	'Michal',
	'Andrej',
	'Miroslav',
	'Šimon',
	'Róbert',
	'Roman',
	'Juraj',
	'Ján',
	'Richard',
	'Jozef',
	'Milan',
	'Dominik',
	'Boris',
	'Matúš',
	'Tibor',
	'Jakub',
	'Andrej',
	'Ladislav',
];


/* Koniec  */

function replaceAll(find, replace, str)
{
	return str.replace(new RegExp(find, 'g'), replace);
}


function _getPersonInfo(obj)
{
	return obj[Math.floor(Math.random() * obj.length)];
}

function _getCity(obj)
{
	return obj[Math.floor(Math.random() * obj.length)];
}

function _getRandomInt(min, max)
{
	return Math.floor(Math.random() * (max - min + 1)) + min;
}

function _getLastName()
{
	var array_size = LAST_NAME_ARRAY.length-1;
	var ind        = _getRandomInt(1, array_size);

	return LAST_NAME_ARRAY[ind] + '.';
}

function _getTime()
{
	var rozsah = _getRandomInt(MIN_TIME, MAX_TIME);

	var now = new Date();
	now.setMinutes(now.getMinutes() - rozsah);

	var hour   = now.getHours();
	var minute = now.getMinutes();

	if (minute < 10)
		minute = '0' + minute;

	return hour + ':' + minute;
}

function _getAmount(dolna, horna, round_to)
{
	var suma = _getRandomInt(dolna, horna);
	suma = Math.ceil(suma / round_to) * round_to;

	return suma.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "&nbsp");
}

function _getDevice()
{
	var prefix = '<i class="';

	var devices = [
		'fa fa-desktop',
		'glyphicon glyphicon-phone',
		'fa fa-tablet',
		'fa fa-laptop'
	];

	var postfix = '"></i>';

	return prefix + devices[Math.floor(Math.random() * devices.length)] + postfix;
}

function _setCookie(cname, cvalue)
{
	var now        = new Date();
	var time       = now.getTime();
	var expireTime = time + 36000 * 1000;
	now.setTime(expireTime);

	var path = "path=/";
	document.cookie = cname + "=" + cvalue + ";expires=" + now.toGMTString() + ";" + path;
}

function _getCookie(cname)
{
	var name = cname + "=";
	var ca   = document.cookie.split(';');

	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

function _checkCookie(cname)
{
	var check = _getCookie(cname);
	return check != "";
}

function getPerson(id_element, dolna_hranica, horna_hranica, krajina, round_to)
{
	getPersonWithLocalization(id_element, dolna_hranica, horna_hranica, krajina, round_to, true);
}

function getPersonWithLocalization(id_element, dolna_hranica, horna_hranica, krajina, round_to, localization)
{
	var person;

	var mena     	= '';
	var city 	 	= '';
	var lang		= typeof krajina === 'object' || krajina === undefined || krajina == '' ? 'cz' : krajina;
	var element  	= typeof id_element === 'object' || id_element === undefined || id_element == '' ? 'element' : id_element;
	var dolna    	= typeof dolna_hranica === 'object' || dolna_hranica === undefined || dolna_hranica == '' ? '100' : dolna_hranica;
	var horna    	= typeof horna_hranica === 'object' || horna_hranica === undefined || horna_hranica == '' ? '1000' : horna_hranica;
	var round_to 	= typeof round_to === 'object' || round_to === undefined || round_to == '' ? '50' : round_to;

	horna = horna.replace(/ /g,'');
	horna = horna.replace(/ /g, '');
	horna = parseInt(replaceAll('&nbsp;', '', horna));

	dolna = dolna.replace(/ /g,'');
	dolna = dolna.replace(/ /g, '');
	dolna = parseInt(replaceAll('&nbsp;', '', dolna));

	round_to = round_to.replace(/ /g,'');
	round_to = parseInt(replaceAll('&nbsp;', '', round_to));

	var win   = window.location.pathname;
	var regex = new RegExp('/', 'g');
	win       = win.replace(regex, '_');

	if (_checkCookie('p_' + id_element + win)) {
		try {
			var json = _getCookie('p_' + id_element + win);
			person   = JSON.parse(json);
		} catch (e) {
			console.log('Chyba pri nacitani cookie');
		}
	}

	if (person === undefined) {
		person = {};

		if (localization) {
			$.getJSON(URL, function(response) {
				if (response.country_code.toLowerCase() == lang.toLowerCase()) {
					person.city = response.city;

					$("." + id_element + "_place").html(person.city);

					var json = JSON.stringify(person);
					_setCookie('p_' + id_element + win, json);
				}

			}).fail(function() {
				console.log('Chyba pri nacitani polohy');
			});
		}

		var gender = Math.random() > 0.5 ? 'male' : 'female';

		switch (lang) {
			case 'sk':
				person.first_name = _getPersonInfo(gender == 'male' ? SK_MALE_NAME : SK_FEMALE_NAME);
				person.end  = gender == 'female' ? 'a' : '';
				mena        = '&#8364';
				person.city	= _getCity(SK_CITY);
				break;

			case 'cz':
				person.first_name = _getPersonInfo(gender == 'male' ? CZ_MALE_NAME : CZ_FEMALE_NAME);
				person.end  = gender == 'female' ? 'a' : '';
				mena        = 'Kč';
				person.city	= _getCity(CZ_CITY);
				break;

			case 'pl':
				person.first_name = _getPersonInfo(gender == 'male' ? PL_MALE_NAME : PL_FEMALE_NAME);
				person.end  = gender == 'female' ? 'a' : '';
				mena        = 'zł';
				person.city	= _getCity(PL_CITY);
				break;

			case 'es':
				person.first_name = _getPersonInfo(gender == 'male' ? ES_MALE_NAME : ES_FEMALE_NAME);
				person.end  = gender == 'female' ? 'a' : '';
				mena        = '€';
				person.city	= _getCity(ES_CITY);
				break;
		}

		lang = lang.toUpperCase();

		person.last_name = _getLastName();
		person.gender = gender;
		//person.salut = person_info.salut;
		person.time = _getTime();
		person.amount = _getAmount(dolna, horna, round_to) + ' ' + mena;
		person.device = _getDevice();

		var json = JSON.stringify(person);
		_setCookie('p_' + id_element + win, json);
	}

	_setValue(person, id_element);
}

function _setValue(person, id_element)
{
	$("." + id_element + "_first_name").html(person.first_name);
	$("." + id_element + "_last_name").html(person.last_name);
	$("." + id_element + "_salut").html(person.salut);
	$("." + id_element + "_end").html(person.end);
	$("." + id_element + "_time").html(person.time);
	$("." + id_element + "_amount").html(person.amount);
	$("." + id_element + "_place").html(person.city);
	$("." + id_element + "_device").html(person.device);
}


function getApplicantCount(id_element, dolna_pocet, horna_pocet, dolna_cas, horna_cas)
{
	var element     = typeof id_element === 'object' || id_element === undefined || id_element == '' ? 'element' : id_element;
	var dolna_pocet = typeof dolna_pocet === 'object' || dolna_pocet === undefined || dolna_pocet == '' ? 5 : parseInt(dolna_pocet.replace(/ /g,''));
	var horna_pocet = typeof horna_pocet === 'object' || horna_pocet === undefined || horna_pocet == '' ? 120 : parseInt(horna_pocet.replace(/ /g,''));
	var dolna_cas   = typeof dolna_cas === 'object' || dolna_cas === undefined || dolna_cas == '' ? 6 : parseInt(dolna_cas.replace(/ /g,''));
	var horna_cas   = typeof horna_cas === 'object' || horna_cas === undefined || horna_cas == '' ? 19 : parseInt(horna_cas.replace(/ /g,''));


	var win   = window.location.pathname;
	var regex = new RegExp('/', 'g');
	win = win.replace(regex, '_');

	var rozdiel = (horna_cas - dolna_cas)*60;

	var d = new Date();

	var now = Math.floor(d.getTime()/1000);

	d.setHours(dolna_cas, '0', '0');
	var down_time = Math.floor(d.getTime()/1000)

	d.setHours(horna_cas, '0', '0');
	var up_time = Math.floor(d.getTime()/1000)

	if (now < down_time) {
		var applicant = dolna_pocet;
	} else if (now > up_time) {
		var applicant = horna_pocet;
	} else {
		var tmp       = Math.round((now - down_time)/60);
		var a         = (horna_pocet - dolna_pocet)/rozdiel;
		var applicant = Math.round(a * tmp);
	}

	$("." + element).html(applicant);
}