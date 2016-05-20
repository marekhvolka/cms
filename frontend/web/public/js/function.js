
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

/* Slovenske mena */

var SK_NAME = {
	1 : {
		name   	  : 'Alexandra',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	2 : {
		name   	  : 'Karina',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	3 : {
		name   	  : 'Daniela',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	4 : {
		name   	  : 'Andrea',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 3
	},
	5 : {
		name   	  : 'Antónia',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	6 : {
		name   	  : 'Bohuslava',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	7 : {
		name   	  : 'Dáša',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	8 : {
		name   	  : 'Kristína',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 3
	},
	9 : {
		name   	  : 'Nataša',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	10 : {
		name   	  : 'Bohdana',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	11 : {
		name   	  : 'Drahomíra',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	12 : {
		name   	  : 'Sára',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	13 : {
		name   	  : 'Zora',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	14 : {
		name   	  : 'Tamara',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	15 : {
		name   	  : 'Ema',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	16 : {
		name   	  : 'Tatiana',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	17 : {
		name   	  : 'Erika',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	18 : {
		name   	  : 'Veronika',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 8
	},
	19 : {
		name   	  : 'Agáta',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	20 : {
		name   	  : 'Gabriela',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 2
	},
	21 : {
		name   	  : 'Miloslava',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	22 : {
		name   	  : 'Romana',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 3
	},
	23 : {
		name   	  : 'Zlatica',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	24 : {
		name   	  : 'Anežka',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	25 : {
		name   	  : 'Bohumila',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	26 : {
		name   	  : 'Angela',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	27 : {
		name   	  : 'Svetlana',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	28 : {
		name   	  : 'Ľubica',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	29 : {
		name   	  : 'Alena',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	30 : {
		name   	  : 'Soňa',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 2
	},
	31 : {
		name   	  : 'Vieroslava',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	32 : {
		name   	  : 'Miroslava',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	33 : {
		name   	  : 'Irena',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	34 : {
		name   	  : 'Dana',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	35 : {
		name   	  : 'Danica',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	36 : {
		name   	  : 'Jaroslava',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	37 : {
		name   	  : 'Jarmila',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	38 : {
		name   	  : 'Lea',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	39 : {
		name   	  : 'Anastázia',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	40 : {
		name   	  : 'Monika',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 8
	},
	41 : {
		name   	  : 'Viktória',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	42 : {
		name   	  : 'Sofia',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	43 : {
		name   	  : 'Júlia',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	44 : {
		name   	  : 'Ela',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	45 : {
		name   	  : 'Vanesa',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	46 : {
		name   	  : 'Iveta',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	47 : {
		name   	  : 'Petronela',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	48 : {
		name   	  : 'Karolína',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	49 : {
		name   	  : 'Lenka',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 15
	},
	50 : {
		name   	  : 'Laura',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	51 : {
		name   	  : 'Stanislava',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	52 : {
		name   	  : 'Blanka',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	53 : {
		name   	  : 'Paulína',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	54 : {
		name   	  : 'Adriána',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	55 : {
		name   	  : 'Beáta',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	56 : {
		name   	  : 'Petra',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 15
	},
	57 : {
		name   	  : 'Diana',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	58 : {
		name   	  : 'Berta',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	59 : {
		name   	  : 'Patrícia',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	60 : {
		name   	  : 'Kamila',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	61 : {
		name   	  : 'Magdaléna',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	62 : {
		name   	  : 'Oľga',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	63 : {
		name   	  : 'Anna',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	64 : {
		name   	  : 'Hana',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	65 : {
		name   	  : 'Božena',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	66 : {
		name   	  : 'Marta',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	67 : {
		name   	  : 'Dominika',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 5
	},
	68 : {
		name   	  : 'Ľubomíra',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	69 : {
		name   	  : 'Zuzana',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 20
	},
	70 : {
		name   	  : 'Helena',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	71 : {
		name   	  : 'Jana',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 15
	},
	72 : {
		name   	  : 'Silvia',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	73 : {
		name   	  : 'Nikola',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 5
	},
	74 : {
		name   	  : 'Nora',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	75 : {
		name   	  : 'Drahoslava',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	76 : {
		name   	  : 'Linda',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	77 : {
		name   	  : 'Alica',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	78 : {
		name   	  : 'Marianna',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	79 : {
		name   	  : 'Miriama',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	80 : {
		name   	  : 'Martina',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 5
	},
	81 : {
		name   	  : 'Mária',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 6
	},
	82 : {
		name   	  : 'Jolana',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	83 : {
		name   	  : 'Ľudomila',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	84 : {
		name   	  : 'Ľudmila',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	85 : {
		name   	  : 'Ľuboslava',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	86 : {
		name   	  : 'Zdenka',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	87 : {
		name   	  : 'Edita',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	88 : {
		name   	  : 'Michaela',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 9
	},
	89 : {
		name   	  : 'Viera',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	90 : {
		name   	  : 'Natália',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	91 : {
		name   	  : 'Terézia',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	92 : {
		name   	  : 'Vladimíra',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	93 : {
		name   	  : 'Hedviga',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	94 : {
		name   	  : 'Kvetoslava',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	95 : {
		name   	  : 'Klára',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	96 : {
		name   	  : 'Simona',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	97 : {
		name   	  : 'Denisa',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	98 : {
		name   	  : 'Renáta',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	99 : {
		name   	  : 'Klaudia',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	100 : {
		name   	  : 'Alžbeta',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	101 : {
		name   	  : 'Katarína',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 5
	},
	102 : {
		name   	  : 'Barbora',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 5
	},
	103 : {
		name   	  : 'Lucia',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 20
	},
	104 : {
		name   	  : 'Branislava',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	105 : {
		name   	  : 'Adela',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	106 : {
		name   	  : 'Eva',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	107 : {
		name   	  : 'Ivana',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 10
	},
	108 : {
		name   	  : 'Milada',
		salut  	  : 'Pani',
		gender    : 'female',
		frequency : 1
	},
	109 : {
		name   	  : "Ernest",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	110 : {
		name   	  : "Rastislav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	111 : {
		name   	  : "Dalibor",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	112 : {
		name   	  : "Vincent",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	113 : {
		name   	  : "Miloš",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	114 : {
		name   	  : "Emil",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	115 : {
		name   	  : "Erik",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 2
		},
	116 : {
		name   	  : "Blažej",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	117 : {
		name   	  : "Zdenko",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	118 : {
		name   	  : "Jaromír",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	119 : {
		name   	  : "Roman",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 5
		},
	120 : {
		name   	  : "Matej",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 4
		},
	121 : {
		name   	  : "Viktor",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	122 : {
		name   	  : "Alexander",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	123 : {
		name   	  : "Radomír",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	124 : {
		name   	  : "Radoslav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	125 : {
		name   	  : "Tomáš",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 10
		},
	126 : {
		name   	  : "Branislav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	127 : {
		name   	  : "Gregor",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	128 : {
		name   	  : "Vlastimil",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	129 : {
		name   	  : "Boleslav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	130 : {
		name   	  : "Eduard",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	131 : {
		name   	  : "Jozef",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	132 : {
		name   	  : "Adrián",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	133 : {
		name   	  : "Gabriel",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	134 : {
		name   	  : "Marián",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 5
		},
	135 : {
		name   	  : "Miroslav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	136 : {
		name   	  : "Richard",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	137 : {
		name   	  : "Igor",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	138 : {
		name   	  : "Rudolf",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	139 : {
		name   	  : "Marcel",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	140 : {
		name   	  : "Juraj",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 9
		},
	141 : {
		name   	  : "Marek",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 8
		},
	142 : {
		name   	  : "Jaroslav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	143 : {
		name   	  : "Urban",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	144 : {
		name   	  : "Dušan",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	145 : {
		name   	  : "Viliam",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	146 : {
		name   	  : "Norbert",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	147 : {
		name   	  : "Róbert",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	148 : {
		name   	  : "Ján",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 20
		},
	149 : {
		name   	  : "Tadeáš",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	150 : {
		name   	  : "Ladislav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	151 : {
		name   	  : "Peter",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 20
		},
	152 : {
		name   	  : "Pavol",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 20
		},
	153 : {
		name   	  : "Miloslav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	154 : {
		name   	  : "Patrik",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 5
		},
	155 : {
		name   	  : "Oliver",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	156 : {
		name   	  : "Ivan",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 7
		},
	157 : {
		name   	  : "Kamil",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	158 : {
		name   	  : "Daniel",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	159 : {
		name   	  : "Vladimír",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	160 : {
		name   	  : "Jakub",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 9
		},
	161 : {
		name   	  : "Krištof",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	162 : {
		name   	  : "Dominik",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	163 : {
		name   	  : "Ľubomír",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	164 : {
		name   	  : "Filip",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	165 : {
		name   	  : "Ľudovít",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	166 : {
		name   	  : "Samuel",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	167 : {
		name   	  : "Matúš",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 5
		},
	168 : {
		name   	  : "Ľuboš",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	169 : {
		name   	  : "Vladislav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
		},
	170 : {
		name   	  : "Václav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	171 : {
		name   	  : "Michal",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 20
	},
	172 : {
		name   	  : "František",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	173 : {
		name   	  : "Boris",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	174 : {
		name   	  : "Lukáš",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 10
	},
	175 : {
		name   	  : "Kristián",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	176 : {
		name   	  : "Denis",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	177 : {
		name   	  : "Karol",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	178 : {
		name   	  : "Maroš",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	179 : {
		name   	  : "Martin",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 20
	},
	180 : {
		name   	  : "Stanislav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	181 : {
		name   	  : "Leopold",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	182 : {
		name   	  : "Eugen",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	183 : {
		name   	  : "Milan",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	184 : {
		name   	  : "Ondrej",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	185 : {
		name   	  : "Andrej",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	186 : {
		name   	  : "Adam",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	187 : {
		name   	  : "Štefan",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	188 : {
		name   	  : "Dávid",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	}
};

/* Koniec */

/* Ceske mena */

var CZ_NAME = {
	1 : {
		name   	  : "Marie",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	2 : {
		name   	  : "Jana",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	3 : {
		name   	  : "Eva",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	4 : {
		name   	  : "Hana",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	5 : {
		name   	  : "Anna",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	6 : {
		name   	  : "Lenka",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	7 : {
		name   	  : "Věra",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	8 : {
		name   	  : "Kateřina",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	9 : {
		name   	  : "Lucie",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	10 : {
		name   	  : "Alena",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	11 : {
		name   	  : "Petra",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	12 : {
		name   	  : "Jaroslava",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	13 : {
		name   	  : "Veronika",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	14 : {
		name   	  : "Martina",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	15 : {
		name   	  : "Jitka",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	16 : {
		name   	  : "Ludmila",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	17 : {
		name   	  : "Helena",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	18 : {
		name   	  : "Michaela",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	19 : {
		name   	  : "Tereza",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	20 : {
		name   	  : "Zdeňka",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	21 : {
		name   	  : "Ivana",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	22 : {
		name   	  : "Jarmila",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	23 : {
		name   	  : "Monika",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	24 : {
		name   	  : "Jiřina",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	25 : {
		name   	  : "Zuzana",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	26 : {
		name   	  : "Markéta",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	27 : {
		name   	  : "Marcela",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	28 : {
		name   	  : "Eliška",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	29 : {
		name   	  : "Barbora",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	30 : {
		name   	  : "Dagmar",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	31 : {
		name   	  : "Dana",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	32 : {
		name   	  : "Vlasta",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	33 : {
		name   	  : "Kristýna",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	34 : {
		name   	  : "Božena",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	35 : {
		name   	  : "Libuše",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	36 : {
		name   	  : "Irena",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	37 : {
		name   	  : "Miroslava",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	38 : {
		name   	  : "Pavla",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	39 : {
		name   	  : "Marta",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	40 : {
		name   	  : "Andrea",
		salut  	  : "Paní",
		gender 	  : "female",
		frequency : 1
	},
	41 : {
		name   	  : "Jiří",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	42 : {
		name   	  : "Jan",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	43 : {
		name   	  : "Petr",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	44 : {
		name   	  : "Josef",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	45 : {
		name   	  : "Pavel",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	46 : {
		name   	  : "Martin",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	47 : {
		name   	  : "Jaroslav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	48 : {
		name   	  : "Tomáš",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	49 : {
		name   	  : "Miroslav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	50 : {
		name   	  : "Zdeněk",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	51 : {
		name   	  : "František",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	52 : {
		name   	  : "Václav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	53 : {
		name   	  : "Michal",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 10
	},
	54 : {
		name   	  : "Milan",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	55 : {
		name   	  : "Karel",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	56 : {
		name   	  : "Jakub",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	57 : {
		name   	  : "Lukáš",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	58 : {
		name   	  : "David",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	59 : {
		name   	  : "Vladimír",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	60 : {
		name   	  : "Ladislav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	61 : {
		name   	  : "Ondřej",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	62 : {
		name   	  : "Roman",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	63 : {
		name   	  : "Stanislav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	64 : {
		name   	  : "Marek",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	65 : {
		name   	  : "Radek",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	66 : {
		name   	  : "Daniel",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	67 : {
		name   	  : "Antonín",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	68 : {
		name   	  : "Vojtěch",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	69 : {
		name   	  : "Filip",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	70 : {
		name   	  : "Adam",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	71 : {
		name   	  : "Miloslav",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	72 : {
		name   	  : "Matěj",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	73 : {
		name   	  : "Aleš",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	74 : {
		name   	  : "Jaromír",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	75 : {
		name   	  : "Libor",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	76 : {
		name   	  : "Dominik",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	77 : {
		name   	  : "Patrik",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	78 : {
		name   	  : "Vlastimil",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	79 : {
		name   	  : "Jindřich",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	},
	80 : {
		name   	  : "Miloš",
		salut  	  : 'Pán',
		gender 	  : 'male',
		frequency : 1
	}
};


/* Koniec  */

function replaceAll(find, replace, str)
{
  return str.replace(new RegExp(find, 'g'), replace);
}


function _getPersonInfo(obj)
{
	var name     = [];
	var obj_size = Object.keys(obj).length;

	for(var i = 1; i <= obj_size; i++)
	{
		for(var j = 1; j <= obj[i].frequency; j++)
		{	
			name.push(obj[i]);
		}
	}

	var obj_size = Object.keys(name).length;
	var ind      = _getRandomInt(0, obj_size);

	return name[ind];
}

function _getCity(obj)
{
	return obj[Math.floor(Math.random()*obj.length)];
}

function _getRandomInt(min, max)
{
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function _getLastName()
{
	var array_size = LAST_NAME_ARRAY.length-1;
	var ind        = _getRandomInt(1, array_size);

	return LAST_NAME_ARRAY[ind]+'.';
}

function _getTime()
{
	var rozsah = _getRandomInt(MIN_TIME, MAX_TIME);

	var now = new Date();
	now.setMinutes(now.getMinutes() - rozsah);

	var hour   = now.getHours();
	var minute = now.getMinutes();

	if(minute < 10)
		minute = '0'+minute;

	return hour+':'+minute;
}

function _getAmount(dolna, horna, round_to)
{
	var suma = _getRandomInt(dolna, horna);
	suma = Math.ceil(suma / round_to) * round_to;
	
	return suma.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "&nbsp");
}

function _setCookie(cname, cvalue)
{
	var now        = new Date();
	var time       = now.getTime();
	var expireTime = time + 36000 * 1000;
	now.setTime(expireTime);

    var path = "path=/";
    document.cookie = cname + "=" + cvalue + ";expires="+now.toGMTString()+";" + path;
}

function _getCookie(cname)
{
	var name = cname + "=";
	var ca   = document.cookie.split(';');
    
    for(var i=0; i<ca.length; i++)
    {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function _checkCookie(cname)
{
    var check = _getCookie(cname);
    if(check != "")
    {
        return true;
    }
    else
    {
        return false;
    }
}

function getPerson(id_element, dolna_hranica, horna_hranica, krajina, round_to)
{
	var lang = krajina === undefined || krajina == '' ? 'cz' : krajina;

	var person;

	var mena     = '';
	var city 	 = '';
	var element  = id_element === undefined || id_element == '' ? 'element' : id_element;
	var dolna    = dolna_hranica === undefined || dolna_hranica == '' ? '100' : dolna_hranica;
	var horna    = horna_hranica === undefined || horna_hranica == '' ? '1000' : horna_hranica;
	var round_to = round_to === undefined || round_to == '' ? '50' : round_to;

	horna = horna.replace(/ /g,'');
	horna = parseInt(replaceAll('&nbsp;', '', horna));

	dolna = dolna.replace(/ /g,'');
	dolna = parseInt(replaceAll('&nbsp;', '', dolna));

	round_to = round_to.replace(/ /g,'');
	round_to = parseInt(replaceAll('&nbsp;', '', round_to));

	var win   = window.location.pathname;
	var regex = new RegExp('/', 'g');
	win       = win.replace(regex, '_');

	if (_checkCookie('p_'+id_element+win))
	{
		try
		{
			var json = _getCookie('p_'+id_element+win);
			person   = JSON.parse(json);	
		}
		catch (e)
		{
			console.log('Chyba pri nacitani cookie');
		}
	}

	if(person === undefined)
	{
		person = {};

		$.getJSON(URL, function(response)
		{
			person.city = response.city;

			$("."+id_element+"_place").html(person.city);
			
			var json = JSON.stringify(person);
			_setCookie('p_'+id_element+win, json);

		}).fail(function()
		{
			console.log('Chyba pri nacitani polohy');

		});

		switch(lang)
		{
			case 'sk':

				person_info = _getPersonInfo(SK_NAME);
				person.end  = person_info.gender == 'female' ? 'a' : '';
				mena        = '&#8364';
				person.city	= _getCity(SK_CITY);

			break;

			case 'cz':

				person_info = _getPersonInfo(CZ_NAME);
				person.end  = person_info.gender == 'female' ? 'a' : '';
				mena        = 'Kč';
				person.city	= _getCity(CZ_CITY);

			break;
		}

		lang = lang.toUpperCase();

		person.first_name = person_info.name;
		person.last_name  = _getLastName();
		person.gender     = person_info.gender;
		person.salut      = person_info.salut;
		person.time 	  = _getTime();
		person.amount 	  = _getAmount(dolna, horna, round_to) + ' ' + mena;

		var json = JSON.stringify(person);
		_setCookie('p_'+id_element+win, json);
	}
	
	_setValue(person, id_element);
}

function _setValue(person, id_element)
{
	$("."+id_element+"_first_name").html(person.first_name);
	$("."+id_element+"_last_name").html(person.last_name);
	$("."+id_element+"_salut").html(person.salut);
	$("."+id_element+"_end").html(person.end);
	$("."+id_element+"_time").html(person.time);
	$("."+id_element+"_amount").html(person.amount);
	$("."+id_element+"_place").html(person.city);
}


function getApplicantCount(id_element, dolna_pocet, horna_pocet, dolna_cas, horna_cas)
{
	var element     = id_element === undefined || id_element == '' ? 'element' : id_element;
	var dolna_pocet = dolna_pocet === undefined || dolna_pocet == '' ? 5 : parseInt(dolna_pocet.replace(/ /g,''));
	var horna_pocet = horna_pocet === undefined || horna_pocet == '' ? 120 : parseInt(horna_pocet.replace(/ /g,''));
	var dolna_cas   = dolna_cas === undefined || dolna_cas == '' ? 6 : parseInt(dolna_cas.replace(/ /g,''));
	var horna_cas   = horna_cas === undefined || horna_cas == '' ? 19 : parseInt(horna_cas.replace(/ /g,''));
	

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

	if(now < down_time)
	{
		var applicant = dolna_pocet;
	}
	else if(now > up_time)
	{
		var applicant = horna_pocet;
	}
	else
	{
		var tmp       = Math.round((now-down_time)/60);
		var a         = (horna_pocet-dolna_pocet)/rozdiel;
		var applicant = Math.round(a*tmp);
	}

	$("."+element).html(applicant);
}