<script setup>
import {reactive, ref} from 'vue'
import { Head, useForm, router } from '@inertiajs/vue3';
import {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionRoot,
    TransitionChild
} from '@headlessui/vue'
import { FunnelIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import Field from '../Components/Field.vue'
import BaseInput from '../Components/BaseInput.vue'
import BaseRadioGroup from '../Components/Radio/BaseRadioGroup.vue'
import BaseLabel from '../Components/BaseLabel.vue'
import Alert from '../Components/Alert.vue';
import Paginate from '../Components/Pagination.vue'
import backgroundImgUrl from '@/Asset/images/background2.jpg'
import Profile from '../Components/Profile.vue'

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    researchs: {
        type: Object,
        default: []
    },
});

const form = useForm({
    research_title_eng: null,
    author_first: null,
    journal_name: null,
    doi: null,
    publication_date: 0,
})

const publication_date = [
    { value: 0, label: 'All'},
    { value: 1, label: '1 year' },
    { value: 5, label: '5 years' },
    { value: 10, label: '10 years' },
]

//const backgroundImgUrl = new URL('@/assets/images/background2.jpg', import.meta.url)
const isOpen = ref(false)
let checkoutButtonRef =ref(null)
const showAlert = ref(false)
let userInfo = reactive({})

const fakeUser = [
    {
        "id": 1,
        "firstName": "Terry",
        "lastName": "Medhurst",
        "maidenName": "Smitham",
        "age": 50,
        "gender": "male",
        "email": "atuny0@sohu.com",
        "phone": "+63 791 675 8914",
        "username": "atuny0",
        "password": "9uQFF1Lh",
        "birthDate": "2000-12-25",
        "image": "https://robohash.org/hicveldicta.png",
        "bloodGroup": "A−",
        "height": 189,
        "weight": 75.4,
        "eyeColor": "Green",
        "hair": {
            "color": "Black",
            "type": "Strands"
        },
        "domain": "slashdot.org",
        "ip": "117.29.86.254",
        "address": {
            "address": "1745 T Street Southeast",
            "city": "Washington",
            "coordinates": {
                "lat": 38.867033,
                "lng": -76.979235
            },
            "postalCode": "20020",
            "state": "DC"
        },
        "macAddress": "13:69:BA:56:A3:74",
        "university": "Capitol University",
        "bank": {
            "cardExpire": "06/22",
            "cardNumber": "50380955204220685",
            "cardType": "maestro",
            "currency": "Peso",
            "iban": "NO17 0695 2754 967"
        },
        "company": {
            "address": {
                "address": "629 Debbie Drive",
                "city": "Nashville",
                "coordinates": {
                    "lat": 36.208114,
                    "lng": -86.58621199999999
                },
                "postalCode": "37076",
                "state": "TN"
            },
            "department": "Marketing",
            "name": "Blanda-O'Keefe",
            "title": "Help Desk Operator"
        },
        "ein": "20-9487066",
        "ssn": "661-64-2976",
        "userAgent": "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/12.0.702.0 Safari/534.24"
    },
    {
        "id": 2,
        "firstName": "Sheldon",
        "lastName": "Quigley",
        "maidenName": "Cole",
        "age": 28,
        "gender": "male",
        "email": "hbingley1@plala.or.jp",
        "phone": "+7 813 117 7139",
        "username": "hbingley1",
        "password": "CQutx25i8r",
        "birthDate": "2003-08-02",
        "image": "https://robohash.org/doloremquesintcorrupti.png",
        "bloodGroup": "O+",
        "height": 187,
        "weight": 74,
        "eyeColor": "Brown",
        "hair": {
            "color": "Blond",
            "type": "Curly"
        },
        "domain": "51.la",
        "ip": "253.240.20.181",
        "address": {
            "address": "6007 Applegate Lane",
            "city": "Louisville",
            "coordinates": {
                "lat": 38.1343013,
                "lng": -85.6498512
            },
            "postalCode": "40219",
            "state": "KY"
        },
        "macAddress": "13:F1:00:DA:A4:12",
        "university": "Stavropol State Technical University",
        "bank": {
            "cardExpire": "10/23",
            "cardNumber": "5355920631952404",
            "cardType": "mastercard",
            "currency": "Ruble",
            "iban": "MD63 L6YC 8YH4 QVQB XHIK MTML"
        },
        "company": {
            "address": {
                "address": "8821 West Myrtle Avenue",
                "city": "Glendale",
                "coordinates": {
                    "lat": 33.5404296,
                    "lng": -112.2488391
                },
                "postalCode": "85305",
                "state": "AZ"
            },
            "department": "Services",
            "name": "Aufderhar-Cronin",
            "title": "Senior Cost Accountant"
        },
        "ein": "52-5262907",
        "ssn": "447-08-9217",
        "userAgent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.30 (KHTML, like Gecko) Ubuntu/11.04 Chromium/12.0.742.112 Chrome/12.0.742.112 Safari/534.30"
    },
    {
        "id": 3,
        "firstName": "Terrill",
        "lastName": "Hills",
        "maidenName": "Hoeger",
        "age": 38,
        "gender": "male",
        "email": "rshawe2@51.la",
        "phone": "+63 739 292 7942",
        "username": "rshawe2",
        "password": "OWsTbMUgFc",
        "birthDate": "1992-12-30",
        "image": "https://robohash.org/consequunturautconsequatur.png",
        "bloodGroup": "A−",
        "height": 200,
        "weight": 105.3,
        "eyeColor": "Gray",
        "hair": {
            "color": "Blond",
            "type": "Very curly"
        },
        "domain": "earthlink.net",
        "ip": "205.226.160.3",
        "address": {
            "address": "560 Penstock Drive",
            "city": "Grass Valley",
            "coordinates": {
                "lat": 39.213076,
                "lng": -121.077583
            },
            "postalCode": "95945",
            "state": "CA"
        },
        "macAddress": "F2:88:58:64:F7:76",
        "university": "University of Cagayan Valley",
        "bank": {
            "cardExpire": "10/23",
            "cardNumber": "3586082982526703",
            "cardType": "jcb",
            "currency": "Peso",
            "iban": "AT24 1095 9625 1434 9703"
        },
        "company": {
            "address": {
                "address": "18 Densmore Drive",
                "city": "Essex",
                "coordinates": {
                    "lat": 44.492953,
                    "lng": -73.101883
                },
                "postalCode": "05452",
                "state": "VT"
            },
            "department": "Marketing",
            "name": "Lindgren LLC",
            "title": "Mechanical Systems Engineer"
        },
        "ein": "48-3951994",
        "ssn": "633-89-1926",
        "userAgent": "Mozilla/5.0 (Windows NT 6.2; Win64; x64; rv:21.0.0) Gecko/20121011 Firefox/21.0.0"
    },
    {
        "id": 4,
        "firstName": "Miles",
        "lastName": "Cummerata",
        "maidenName": "Maggio",
        "age": 49,
        "gender": "male",
        "email": "yraigatt3@nature.com",
        "phone": "+86 461 145 4186",
        "username": "yraigatt3",
        "password": "sRQxjPfdS",
        "birthDate": "1969-01-16",
        "image": "https://robohash.org/facilisdignissimosdolore.png",
        "bloodGroup": "B+",
        "height": 157,
        "weight": 95.9,
        "eyeColor": "Gray",
        "hair": {
            "color": "Blond",
            "type": "Very curly"
        },
        "domain": "homestead.com",
        "ip": "243.20.78.113",
        "address": {
            "address": "150 Carter Street",
            "city": "Manchester",
            "coordinates": {
                "lat": 41.76556000000001,
                "lng": -72.473091
            },
            "postalCode": "06040",
            "state": "CT"
        },
        "macAddress": "03:45:58:59:5A:7B",
        "university": "Shenyang Pharmaceutical University",
        "bank": {
            "cardExpire": "07/24",
            "cardNumber": "3580047879369323",
            "cardType": "jcb",
            "currency": "Yuan Renminbi",
            "iban": "KZ43 658B M6VS TZOU OXSO"
        },
        "company": {
            "address": {
                "address": "210 Green Road",
                "city": "Manchester",
                "coordinates": {
                    "lat": 41.7909099,
                    "lng": -72.51195129999999
                },
                "postalCode": "06042",
                "state": "CT"
            },
            "department": "Business Development",
            "name": "Wolff and Sons",
            "title": "Paralegal"
        },
        "ein": "71-3644334",
        "ssn": "487-28-6642",
        "userAgent": "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.17 Safari/537.11"
    },
    {
        "id": 5,
        "firstName": "Mavis",
        "lastName": "Schultz",
        "maidenName": "Yundt",
        "age": 38,
        "gender": "male",
        "email": "kmeus4@upenn.edu",
        "phone": "+372 285 771 1911",
        "username": "kmeus4",
        "password": "aUTdmmmbH",
        "birthDate": "1968-11-03",
        "image": "https://robohash.org/adverovelit.png",
        "bloodGroup": "O+",
        "height": 188,
        "weight": 106.3,
        "eyeColor": "Brown",
        "hair": {
            "color": "Brown",
            "type": "Curly"
        },
        "domain": "columbia.edu",
        "ip": "103.72.86.183",
        "address": {
            "address": "2721 Lindsay Avenue",
            "city": "Louisville",
            "coordinates": {
                "lat": 38.263793,
                "lng": -85.700243
            },
            "postalCode": "40206",
            "state": "KY"
        },
        "macAddress": "F8:04:9E:ED:C0:68",
        "university": "Estonian University of Life Sciences",
        "bank": {
            "cardExpire": "01/24",
            "cardNumber": "4917245076693618",
            "cardType": "visa-electron",
            "currency": "Euro",
            "iban": "IT41 T114 5127 716J RGYB ZRUX DSJ"
        },
        "company": {
            "address": {
                "address": "8398 West Denton Lane",
                "city": "Glendale",
                "coordinates": {
                    "lat": 33.515353,
                    "lng": -112.240812
                },
                "postalCode": "85305",
                "state": "AZ"
            },
            "department": "Support",
            "name": "Adams Inc",
            "title": "Web Developer I"
        },
        "ein": "18-7178563",
        "ssn": "667-98-5357",
        "userAgent": "Mozilla/5.0 (Windows NT 6.0) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/13.0.782.1 Safari/535.1"
    },
    {
        "id": 6,
        "firstName": "Alison",
        "lastName": "Reichert",
        "maidenName": "Franecki",
        "age": 21,
        "gender": "female",
        "email": "jtreleven5@nhs.uk",
        "phone": "+351 527 735 3642",
        "username": "jtreleven5",
        "password": "zY1nE46Zm",
        "birthDate": "1969-07-21",
        "image": "https://robohash.org/laboriosamfacilisrem.png",
        "bloodGroup": "A+",
        "height": 149,
        "weight": 105.7,
        "eyeColor": "Amber",
        "hair": {
            "color": "Blond",
            "type": "Straight"
        },
        "domain": "bandcamp.com",
        "ip": "49.201.206.36",
        "address": {
            "address": "18 Densmore Drive",
            "city": "Essex",
            "coordinates": {
                "lat": 44.492953,
                "lng": -73.101883
            },
            "postalCode": "05452",
            "state": "VT"
        },
        "macAddress": "6C:34:D0:4B:4E:81",
        "university": "Universidade da Beira Interior",
        "bank": {
            "cardExpire": "03/22",
            "cardNumber": "345675888286047",
            "cardType": "americanexpress",
            "currency": "Euro",
            "iban": "LB69 1062 QCY5 XS5T VOKU KJFG XP4S"
        },
        "company": {
            "address": {
                "address": "6231 North 67th Avenue",
                "city": "Glendale",
                "coordinates": {
                    "lat": 33.5279666,
                    "lng": -112.2022551
                },
                "postalCode": "85301",
                "state": "AZ"
            },
            "department": "Accounting",
            "name": "D'Amore and Sons",
            "title": "Civil Engineer"
        },
        "ein": "78-3192791",
        "ssn": "158-68-0184",
        "userAgent": "Mozilla/5.0 (Windows; U; Windows NT 6.0; nb-NO) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5"
    },
    {
        "id": 7,
        "firstName": "Oleta",
        "lastName": "Abbott",
        "maidenName": "Wyman",
        "age": 31,
        "gender": "female",
        "email": "dpettegre6@columbia.edu",
        "phone": "+62 640 802 7111",
        "username": "dpettegre6",
        "password": "YVmhktgYVS",
        "birthDate": "1982-02-21",
        "image": "https://robohash.org/cupiditatererumquos.png",
        "bloodGroup": "B−",
        "height": 172,
        "weight": 78.1,
        "eyeColor": "Blue",
        "hair": {
            "color": "Chestnut",
            "type": "Wavy"
        },
        "domain": "ovh.net",
        "ip": "25.207.107.146",
        "address": {
            "address": "637 Britannia Drive",
            "city": "Vallejo",
            "coordinates": {
                "lat": 38.10476999999999,
                "lng": -122.193849
            },
            "postalCode": "94591",
            "state": "CA"
        },
        "macAddress": "48:2D:A0:67:19:E0",
        "university": "Institut Sains dan Teknologi Al Kamal",
        "bank": {
            "cardExpire": "10/23",
            "cardNumber": "3589640949470047",
            "cardType": "jcb",
            "currency": "Rupiah",
            "iban": "GI97 IKPF 9DUO X25M FG8D UXY"
        },
        "company": {
            "address": {
                "address": "1407 Walden Court",
                "city": "Crofton",
                "coordinates": {
                    "lat": 39.019306,
                    "lng": -76.660653
                },
                "postalCode": "21114",
                "state": "MD"
            },
            "department": "Product Management",
            "name": "Schimmel, Wilderman and Orn",
            "title": "Sales Associate"
        },
        "ein": "29-1568401",
        "ssn": "478-11-2206",
        "userAgent": "Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5"
    },
    {
        "id": 8,
        "firstName": "Ewell",
        "lastName": "Mueller",
        "maidenName": "Durgan",
        "age": 29,
        "gender": "male",
        "email": "ggude7@chron.com",
        "phone": "+86 946 297 2275",
        "username": "ggude7",
        "password": "MWwlaeWcOoF6",
        "birthDate": "1964-08-24",
        "image": "https://robohash.org/quiaharumsapiente.png",
        "bloodGroup": "A−",
        "height": 146,
        "weight": 52.1,
        "eyeColor": "Blue",
        "hair": {
            "color": "Chestnut",
            "type": "Wavy"
        },
        "domain": "homestead.com",
        "ip": "91.200.56.127",
        "address": {
            "address": "5601 West Crocus Drive",
            "city": "Glendale",
            "coordinates": {
                "lat": 33.6152469,
                "lng": -112.179737
            },
            "postalCode": "85306",
            "state": "AZ"
        },
        "macAddress": "72:DA:1B:D7:30:E9",
        "university": "Wenzhou Medical College",
        "bank": {
            "cardExpire": "09/23",
            "cardNumber": "30549925358905",
            "cardType": "diners-club-carte-blanche",
            "currency": "Yuan Renminbi",
            "iban": "CY02 9914 5346 0PMT G6XW TP0R AWRZ"
        },
        "company": {
            "address": {
                "address": "81 Seaton Place Northwest",
                "city": "Washington",
                "coordinates": {
                    "lat": 38.9149499,
                    "lng": -77.01170259999999
                },
                "postalCode": "20001",
                "state": "DC"
            },
            "department": "Services",
            "name": "Corkery, Reichert and Hodkiewicz",
            "title": "Clinical Specialist"
        },
        "ein": "88-4396827",
        "ssn": "238-41-5528",
        "userAgent": "Mozilla/5.0 (X11; Linux amd64) AppleWebKit/534.36 (KHTML, like Gecko) Chrome/13.0.766.0 Safari/534.36"
    },
    {
        "id": 9,
        "firstName": "Demetrius",
        "lastName": "Corkery",
        "maidenName": "Gleason",
        "age": 22,
        "gender": "male",
        "email": "nloiterton8@aol.com",
        "phone": "+86 356 590 9727",
        "username": "nloiterton8",
        "password": "HTQxxXV9Bq4",
        "birthDate": "1971-03-11",
        "image": "https://robohash.org/excepturiiuremolestiae.png",
        "bloodGroup": "A+",
        "height": 170,
        "weight": 97.1,
        "eyeColor": "Green",
        "hair": {
            "color": "Brown",
            "type": "Strands"
        },
        "domain": "goodreads.com",
        "ip": "78.170.185.120",
        "address": {
            "address": "5403 Illinois Avenue",
            "city": "Nashville",
            "coordinates": {
                "lat": 36.157077,
                "lng": -86.853827
            },
            "postalCode": "37209",
            "state": "TN"
        },
        "macAddress": "98:EE:94:A2:91:C4",
        "university": "Nanjing University of Economics",
        "bank": {
            "cardExpire": "02/24",
            "cardNumber": "5372664789004621",
            "cardType": "mastercard",
            "currency": "Yuan Renminbi",
            "iban": "BR68 9829 0581 3669 5088 5533 025N V"
        },
        "company": {
            "address": {
                "address": "12245 West 71st Place",
                "city": "Arvada",
                "coordinates": {
                    "lat": 39.8267078,
                    "lng": -105.1366798
                },
                "postalCode": "80004",
                "state": "CO"
            },
            "department": "Human Resources",
            "name": "Gorczany Group",
            "title": "Community Outreach Specialist"
        },
        "ein": "14-1066382",
        "ssn": "717-26-3759",
        "userAgent": "Mozilla/5.0 (Macintosh; U; PPC Mac OS X 10_4_11; de) AppleWebKit/528.4+ (KHTML, like Gecko) Version/4.0dp1 Safari/526.11.2"
    },
    {
        "id": 10,
        "firstName": "Eleanora",
        "lastName": "Price",
        "maidenName": "Cummings",
        "age": 37,
        "gender": "female",
        "email": "umcgourty9@jalbum.net",
        "phone": "+60 184 408 0824",
        "username": "umcgourty9",
        "password": "i0xzpX",
        "birthDate": "1958-08-11",
        "image": "https://robohash.org/aliquamcumqueiure.png",
        "bloodGroup": "O+",
        "height": 198,
        "weight": 48,
        "eyeColor": "Blue",
        "hair": {
            "color": "Chestnut",
            "type": "Wavy"
        },
        "domain": "alibaba.com",
        "ip": "73.15.179.178",
        "address": {
            "address": "8821 West Myrtle Avenue",
            "city": "Glendale",
            "coordinates": {
                "lat": 33.5404296,
                "lng": -112.2488391
            },
            "postalCode": "85305",
            "state": "AZ"
        },
        "macAddress": "BC:A9:D8:98:CB:0B",
        "university": "Melaka City Polytechnic",
        "bank": {
            "cardExpire": "01/24",
            "cardNumber": "3557806620295254",
            "cardType": "jcb",
            "currency": "Ringgit",
            "iban": "GT40 DWAD 9UHA VEOZ ZF4J 2Y0F OOFD"
        },
        "company": {
            "address": {
                "address": "1649 Timberridge Court",
                "city": "Fayetteville",
                "coordinates": {
                    "lat": 36.084563,
                    "lng": -94.206082
                },
                "postalCode": "72704",
                "state": "AR"
            },
            "department": "Marketing",
            "name": "Bins Group",
            "title": "Senior Sales Associate"
        },
        "ein": "21-5278484",
        "ssn": "544-66-0745",
        "userAgent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.6 Safari/537.11"
    },
    {
        "id": 11,
        "firstName": "Marcel",
        "lastName": "Jones",
        "maidenName": "Smith",
        "age": 39,
        "gender": "male",
        "email": "acharlota@liveinternet.ru",
        "phone": "+967 253 210 0344",
        "username": "acharlota",
        "password": "M9lbMdydMN",
        "birthDate": "1961-09-12",
        "image": "https://robohash.org/impeditautest.png",
        "bloodGroup": "B−",
        "height": 203,
        "weight": 63.7,
        "eyeColor": "Amber",
        "hair": {
            "color": "Black",
            "type": "Straight"
        },
        "domain": "feedburner.com",
        "ip": "137.235.164.173",
        "address": {
            "address": "2203 7th Street Road",
            "city": "Louisville",
            "coordinates": {
                "lat": 38.218107,
                "lng": -85.779006
            },
            "postalCode": "40208",
            "state": "KY"
        },
        "macAddress": "59:E8:70:5A:E5:D6",
        "university": "Hodeidah University",
        "bank": {
            "cardExpire": "05/24",
            "cardNumber": "5893925889459720",
            "cardType": "maestro",
            "currency": "Rial",
            "iban": "NL97 UWMY 2503 2999 43"
        },
        "company": {
            "address": {
                "address": "308 Woodleaf Court",
                "city": "Glen Burnie",
                "coordinates": {
                    "lat": 39.1425931,
                    "lng": -76.6238441
                },
                "postalCode": "21061",
                "state": "MD"
            },
            "department": "Business Development",
            "name": "Kuhn-Harber",
            "title": "Account Executive"
        },
        "ein": "09-3791007",
        "ssn": "342-54-8422",
        "userAgent": "Mozilla/5.0 (Windows NT 5.2) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.792.0 Safari/535.1"
    },
    {
        "id": 12,
        "firstName": "Assunta",
        "lastName": "Rath",
        "maidenName": "Heller",
        "age": 42,
        "gender": "female",
        "email": "rhallawellb@dropbox.com",
        "phone": "+380 962 542 6549",
        "username": "rhallawellb",
        "password": "esTkitT1r",
        "birthDate": "1990-12-14",
        "image": "https://robohash.org/namquaerataut.png",
        "bloodGroup": "O−",
        "height": 168,
        "weight": 96.8,
        "eyeColor": "Gray",
        "hair": {
            "color": "Black",
            "type": "Very curly"
        },
        "domain": "123-reg.co.uk",
        "ip": "74.80.53.208",
        "address": {
            "address": "6463 Vrain Street",
            "city": "Arvada",
            "coordinates": {
                "lat": 39.814056,
                "lng": -105.046913
            },
            "postalCode": "80003",
            "state": "CO"
        },
        "macAddress": "9B:DC:21:C2:30:A3",
        "university": "Kiev Slavonic University",
        "bank": {
            "cardExpire": "09/22",
            "cardNumber": "5602230671060360",
            "cardType": "bankcard",
            "currency": "Hryvnia",
            "iban": "KW76 VNLA LX0Y DMDE PFS8 FVKP VMDF AV"
        },
        "company": {
            "address": {
                "address": "388 East Main Street",
                "coordinates": {
                    "lat": 43.9727945,
                    "lng": -73.1023187
                },
                "postalCode": "05753",
                "state": "VT"
            },
            "department": "Product Management",
            "name": "Goodwin-Skiles",
            "title": "Developer II"
        },
        "ein": "14-1242349",
        "ssn": "116-51-6131",
        "userAgent": "Mozilla/5.0 (X11; CrOS i686 4319.74.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36"
    },
    {
        "id": 13,
        "firstName": "Trace",
        "lastName": "Douglas",
        "maidenName": "Lemke",
        "age": 26,
        "gender": "male",
        "email": "lgribbinc@posterous.com",
        "phone": "+1 609 937 3468",
        "username": "lgribbinc",
        "password": "ftGj8LZTtv9g",
        "birthDate": "1967-07-23",
        "image": "https://robohash.org/voluptatemsintnulla.png",
        "bloodGroup": "O+",
        "height": 181,
        "weight": 56.5,
        "eyeColor": "Amber",
        "hair": {
            "color": "Auburn",
            "type": "Straight"
        },
        "domain": "histats.com",
        "ip": "163.245.232.27",
        "address": {
            "address": "87 Horseshoe Drive",
            "city": "West Windsor",
            "coordinates": {
                "lat": 43.4731793,
                "lng": -72.4967532
            },
            "postalCode": "05037",
            "state": "VT"
        },
        "macAddress": "B9:21:ED:9F:B8:9E",
        "university": "Dallas Christian College",
        "bank": {
            "cardExpire": "01/23",
            "cardNumber": "3556299106119514",
            "cardType": "jcb",
            "currency": "Dollar",
            "iban": "AE47 4194 4544 3401 3419 286"
        },
        "company": {
            "address": {
                "address": "310 Timrod Road",
                "city": "Manchester",
                "coordinates": {
                    "lat": 41.756758,
                    "lng": -72.493501
                },
                "postalCode": "06040",
                "state": "CT"
            },
            "department": "Research and Development",
            "name": "Casper Inc",
            "title": "Sales Associate"
        },
        "ein": "94-0648182",
        "ssn": "217-05-3082",
        "userAgent": "Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU) AppleWebKit/533.19.4 (KHTML, like Gecko) Version/5.0.3 Safari/533.19.4"
    },
    {
        "id": 14,
        "firstName": "Enoch",
        "lastName": "Lynch",
        "maidenName": "Heidenreich",
        "age": 21,
        "gender": "male",
        "email": "mturleyd@tumblr.com",
        "phone": "+94 912 100 5118",
        "username": "mturleyd",
        "password": "GyLnCB8gNIp",
        "birthDate": "1979-08-25",
        "image": "https://robohash.org/quisequienim.png",
        "bloodGroup": "O+",
        "height": 150,
        "weight": 100.3,
        "eyeColor": "Green",
        "hair": {
            "color": "Auburn",
            "type": "Strands"
        },
        "domain": "icio.us",
        "ip": "174.238.43.126",
        "address": {
            "address": "60 Desousa Drive",
            "city": "Manchester",
            "coordinates": {
                "lat": 41.7409259,
                "lng": -72.5619104
            },
            "postalCode": "06040",
            "state": "CT"
        },
        "macAddress": "52:11:E1:31:35:C1",
        "university": "University of Sri Jayawardenapura",
        "bank": {
            "cardExpire": "11/23",
            "cardNumber": "5339467937996728",
            "cardType": "mastercard",
            "currency": "Rupee",
            "iban": "SI28 0812 7967 0952 944"
        },
        "company": {
            "address": {
                "address": "21950 Arnold Center Road",
                "city": "Carson",
                "coordinates": {
                    "lat": 33.8272706,
                    "lng": -118.2302826
                },
                "postalCode": "90810",
                "state": "CA"
            },
            "department": "Sales",
            "name": "Schoen Inc",
            "title": "Professor"
        },
        "ein": "61-8316825",
        "ssn": "742-81-1714",
        "userAgent": "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-en) AppleWebKit/533.16 (KHTML, like Gecko) Version/4.1 Safari/533.16"
    },
    {
        "id": 15,
        "firstName": "Jeanne",
        "lastName": "Halvorson",
        "maidenName": "Cummerata",
        "age": 26,
        "gender": "female",
        "email": "kminchelle@qq.com",
        "phone": "+86 581 108 7855",
        "username": "kminchelle",
        "password": "0lelplR",
        "birthDate": "1996-02-02",
        "image": "https://robohash.org/autquiaut.png",
        "bloodGroup": "A+",
        "height": 176,
        "weight": 45.7,
        "eyeColor": "Amber",
        "hair": {
            "color": "Blond",
            "type": "Straight"
        },
        "domain": "google.co.uk",
        "ip": "78.43.74.226",
        "address": {
            "address": "4 Old Colony Way",
            "city": "Yarmouth",
            "coordinates": {
                "lat": 41.697168,
                "lng": -70.189992
            },
            "postalCode": "02664",
            "state": "MA"
        },
        "macAddress": "D9:DB:D9:5A:01:09",
        "university": "Donghua University, Shanghai",
        "bank": {
            "cardExpire": "10/23",
            "cardNumber": "3588859507772914",
            "cardType": "jcb",
            "currency": "Yuan Renminbi",
            "iban": "FO12 1440 0396 8902 56"
        },
        "company": {
            "address": {
                "address": "22572 Toreador Drive",
                "city": "Salinas",
                "coordinates": {
                    "lat": 36.602449,
                    "lng": -121.699071
                },
                "postalCode": "93908",
                "state": "CA"
            },
            "department": "Marketing",
            "name": "Hahn-MacGyver",
            "title": "Software Test Engineer IV"
        },
        "ein": "62-0561095",
        "ssn": "855-43-8639",
        "userAgent": "Mozilla/5.0 (X11; Linux i686) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.14 Safari/534.24"
    },
    {
        "id": 16,
        "firstName": "Trycia",
        "lastName": "Fadel",
        "maidenName": "Rosenbaum",
        "age": 41,
        "gender": "female",
        "email": "dpierrof@vimeo.com",
        "phone": "+420 833 708 0340",
        "username": "dpierrof",
        "password": "Vru55Y4tufI4",
        "birthDate": "1963-07-03",
        "image": "https://robohash.org/porronumquamid.png",
        "bloodGroup": "B+",
        "height": 166,
        "weight": 87.2,
        "eyeColor": "Gray",
        "hair": {
            "color": "Black",
            "type": "Very curly"
        },
        "domain": "tamu.edu",
        "ip": "82.170.69.15",
        "address": {
            "address": "314 South 17th Street",
            "city": "Nashville",
            "coordinates": {
                "lat": 36.1719075,
                "lng": -86.740228
            },
            "postalCode": "37206",
            "state": "TN"
        },
        "macAddress": "3D:21:5B:9F:76:FF",
        "university": "Technical University of Mining and Metallurgy Ostrava",
        "bank": {
            "cardExpire": "07/23",
            "cardNumber": "6378941710246212",
            "cardType": "instapayment",
            "currency": "Koruna",
            "iban": "CH94 4961 5QY1 VPV1 NGIP P"
        },
        "company": {
            "address": {
                "address": "1407 Walden Court",
                "city": "Crofton",
                "coordinates": {
                    "lat": 39.019306,
                    "lng": -76.660653
                },
                "postalCode": "21114",
                "state": "MD"
            },
            "department": "Research and Development",
            "name": "Steuber, Considine and Padberg",
            "title": "Geological Engineer"
        },
        "ein": "75-1816504",
        "ssn": "677-73-1525",
        "userAgent": "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.872.0 Safari/535.2"
    },
    {
        "id": 17,
        "firstName": "Bradford",
        "lastName": "Prohaska",
        "maidenName": "Bins",
        "age": 43,
        "gender": "male",
        "email": "vcholdcroftg@ucoz.com",
        "phone": "+420 874 628 3710",
        "username": "vcholdcroftg",
        "password": "mSPzYZfR",
        "birthDate": "1975-10-20",
        "image": "https://robohash.org/accusantiumvoluptateseos.png",
        "bloodGroup": "O−",
        "height": 199,
        "weight": 94.3,
        "eyeColor": "Brown",
        "hair": {
            "color": "Black",
            "type": "Curly"
        },
        "domain": "wix.com",
        "ip": "75.75.234.243",
        "address": {
            "address": "1649 Timberridge Court",
            "city": "Fayetteville",
            "coordinates": {
                "lat": 36.084563,
                "lng": -94.206082
            },
            "postalCode": "72704",
            "state": "AR"
        },
        "macAddress": "47:FA:F7:94:7B:5D",
        "university": "Technical University of Mining and Metallurgy Ostrava",
        "bank": {
            "cardExpire": "05/24",
            "cardNumber": "3574627048005672",
            "cardType": "jcb",
            "currency": "Koruna",
            "iban": "SI81 7221 0344 9088 864"
        },
        "company": {
            "address": {
                "address": "20930 Todd Valley Road",
                "city": "Foresthill",
                "coordinates": {
                    "lat": 38.989466,
                    "lng": -120.883108
                },
                "postalCode": "95631",
                "state": "CA"
            },
            "department": "Sales",
            "name": "Bogisich and Sons",
            "title": "Operator"
        },
        "ein": "92-8837697",
        "ssn": "795-36-7752",
        "userAgent": "Mozilla/5.0 (Windows NT 5.2) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.813.0 Safari/535.1"
    },
    {
        "id": 18,
        "firstName": "Arely",
        "lastName": "Skiles",
        "maidenName": "Monahan",
        "age": 42,
        "gender": "male",
        "email": "sberminghamh@chron.com",
        "phone": "+55 886 766 8617",
        "username": "sberminghamh",
        "password": "cAjfb8vg",
        "birthDate": "1958-02-05",
        "image": "https://robohash.org/nihilharumqui.png",
        "bloodGroup": "AB−",
        "height": 192,
        "weight": 97,
        "eyeColor": "Amber",
        "hair": {
            "color": "Brown",
            "type": "Straight"
        },
        "domain": "seesaa.net",
        "ip": "29.82.54.30",
        "address": {
            "address": "5461 West Shades Valley Drive",
            "city": "Montgomery",
            "coordinates": {
                "lat": 32.296422,
                "lng": -86.34280299999999
            },
            "postalCode": "36108",
            "state": "AL"
        },
        "macAddress": "61:0C:8F:92:48:D5",
        "university": "Universidade Estadual do Ceará",
        "bank": {
            "cardExpire": "09/24",
            "cardNumber": "3578078357052002",
            "cardType": "jcb",
            "currency": "Real",
            "iban": "FR79 7925 2903 77HF 2ZY6 TU4M T84"
        },
        "company": {
            "address": {
                "address": "3162 Martin Luther King Junior Boulevard",
                "city": "Fayetteville",
                "coordinates": {
                    "lat": 36.05233310000001,
                    "lng": -94.2056987
                },
                "postalCode": "72704",
                "state": "AR"
            },
            "department": "Support",
            "name": "Metz Group",
            "title": "VP Accounting"
        },
        "ein": "55-4062919",
        "ssn": "551-74-1349",
        "userAgent": "Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0"
    },
    {
        "id": 19,
        "firstName": "Gust",
        "lastName": "Purdy",
        "maidenName": "Abshire",
        "age": 46,
        "gender": "male",
        "email": "bleveragei@so-net.ne.jp",
        "phone": "+86 886 889 0258",
        "username": "bleveragei",
        "password": "UZGAiqPqWQHQ",
        "birthDate": "1989-10-15",
        "image": "https://robohash.org/delenitipraesentiumvoluptatum.png",
        "bloodGroup": "A−",
        "height": 167,
        "weight": 65.3,
        "eyeColor": "Amber",
        "hair": {
            "color": "Black",
            "type": "Straight"
        },
        "domain": "homestead.com",
        "ip": "90.202.216.39",
        "address": {
            "address": "629 Debbie Drive",
            "city": "Nashville",
            "coordinates": {
                "lat": 36.208114,
                "lng": -86.58621199999999
            },
            "postalCode": "37076",
            "state": "TN"
        },
        "macAddress": "22:98:8D:97:2D:AE",
        "university": "Xinjiang University",
        "bank": {
            "cardExpire": "05/22",
            "cardNumber": "5602214306858976",
            "cardType": "bankcard",
            "currency": "Yuan Renminbi",
            "iban": "GB94 MOIU 1274 8449 9733 05"
        },
        "company": {
            "address": {
                "address": "6463 Vrain Street",
                "city": "Arvada",
                "coordinates": {
                    "lat": 39.814056,
                    "lng": -105.046913
                },
                "postalCode": "80003",
                "state": "CO"
            },
            "department": "Sales",
            "name": "Bahringer, Auer and Wehner",
            "title": "Financial Analyst"
        },
        "ein": "53-7190545",
        "ssn": "809-93-2422",
        "userAgent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.3 Safari/534.24"
    },
    {
        "id": 20,
        "firstName": "Lenna",
        "lastName": "Renner",
        "maidenName": "Schumm",
        "age": 41,
        "gender": "female",
        "email": "aeatockj@psu.edu",
        "phone": "+1 904 601 7177",
        "username": "aeatockj",
        "password": "szWAG6hc",
        "birthDate": "1980-01-19",
        "image": "https://robohash.org/ipsumutofficiis.png",
        "bloodGroup": "O−",
        "height": 175,
        "weight": 68,
        "eyeColor": "Green",
        "hair": {
            "color": "Black",
            "type": "Strands"
        },
        "domain": "sourceforge.net",
        "ip": "59.43.194.22",
        "address": {
            "address": "22572 Toreador Drive",
            "city": "Salinas",
            "coordinates": {
                "lat": 36.602449,
                "lng": -121.699071
            },
            "postalCode": "93908",
            "state": "CA"
        },
        "macAddress": "ED:64:AE:91:49:C9",
        "university": "Moraine Valley Community College",
        "bank": {
            "cardExpire": "07/22",
            "cardNumber": "3565173055875732",
            "cardType": "jcb",
            "currency": "Dollar",
            "iban": "GT39 KL9Z CZYV XF26 UPYW SFPT H74U"
        },
        "company": {
            "address": {
                "address": "491 Arabian Way",
                "city": "Grand Junction",
                "coordinates": {
                    "lat": 39.07548999999999,
                    "lng": -108.474785
                },
                "postalCode": "81504",
                "state": "CO"
            },
            "department": "Support",
            "name": "Hoppe Group",
            "title": "Geologist III"
        },
        "ein": "88-6715551",
        "ssn": "389-03-0381",
        "userAgent": "Mozilla/5.0 (X11; Linux i686) AppleWebKit/534.24 (KHTML, like Gecko) Ubuntu/10.10 Chromium/12.0.702.0 Chrome/12.0.702.0 Safari/534.24"
    },
    {
        "id": 21,
        "firstName": "Doyle",
        "lastName": "Ernser",
        "maidenName": "Feeney",
        "age": 23,
        "gender": "male",
        "email": "ckensleyk@pen.io",
        "phone": "+86 634 419 6839",
        "username": "ckensleyk",
        "password": "tq7kPXyf",
        "birthDate": "1983-01-22",
        "image": "https://robohash.org/providenttemporadelectus.png",
        "bloodGroup": "A−",
        "height": 173,
        "weight": 69.9,
        "eyeColor": "Brown",
        "hair": {
            "color": "Black",
            "type": "Curly"
        },
        "domain": "free.fr",
        "ip": "87.213.156.73",
        "address": {
            "address": "3034 Mica Street",
            "city": "Fayetteville",
            "coordinates": {
                "lat": 36.0807929,
                "lng": -94.2066449
            },
            "postalCode": "72704",
            "state": "AR"
        },
        "macAddress": "E2:5A:A5:85:9B:6D",
        "university": "Nanjing University of Traditional Chinese Medicine",
        "bank": {
            "cardExpire": "06/24",
            "cardNumber": "30464640811198",
            "cardType": "diners-club-carte-blanche",
            "currency": "Yuan Renminbi",
            "iban": "BE41 7150 0766 2980"
        },
        "company": {
            "address": {
                "address": "5906 Milton Avenue",
                "city": "Deale",
                "coordinates": {
                    "lat": 38.784451,
                    "lng": -76.54125499999999
                },
                "postalCode": "20751",
                "state": "MD"
            },
            "department": "Product Management",
            "name": "Brekke Group",
            "title": "Programmer Analyst I"
        },
        "ein": "23-4116115",
        "ssn": "562-46-9709",
        "userAgent": "Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.3 (KHTML, like Gecko) Chrome/19.0.1061.0 Safari/536.3"
    },
    {
        "id": 22,
        "firstName": "Tressa",
        "lastName": "Weber",
        "maidenName": "Williamson",
        "age": 41,
        "gender": "female",
        "email": "froachel@howstuffworks.com",
        "phone": "+34 517 104 6248",
        "username": "froachel",
        "password": "rfVSKImC",
        "birthDate": "1987-11-11",
        "image": "https://robohash.org/temporarecusandaeest.png",
        "bloodGroup": "B−",
        "height": 164,
        "weight": 87.1,
        "eyeColor": "Green",
        "hair": {
            "color": "Black",
            "type": "Strands"
        },
        "domain": "indiatimes.com",
        "ip": "71.57.235.192",
        "address": {
            "address": "3729 East Mission Boulevard",
            "city": "Fayetteville",
            "coordinates": {
                "lat": 36.0919353,
                "lng": -94.10654219999999
            },
            "postalCode": "72703",
            "state": "AR"
        },
        "macAddress": "A4:8B:56:BC:ED:98",
        "university": "Universitat Rámon Llull",
        "bank": {
            "cardExpire": "12/21",
            "cardNumber": "342220243660686",
            "cardType": "americanexpress",
            "currency": "Euro",
            "iban": "CY09 2675 2653 QNEJ JNSA 0E2V ONMM"
        },
        "company": {
            "address": {
                "address": "8800 Cordell Circle",
                "city": "Anchorage",
                "coordinates": {
                    "lat": 61.1409305,
                    "lng": -149.9437822
                },
                "postalCode": "99502",
                "state": "AK"
            },
            "department": "Research and Development",
            "name": "Durgan Group",
            "title": "VP Quality Control"
        },
        "ein": "78-2846180",
        "ssn": "155-87-0243",
        "userAgent": "Mozilla/5.0 (Macintosh; U; PPC Mac OS X 10_4_11; de-de) AppleWebKit/533.16 (KHTML, like Gecko) Version/4.1 Safari/533.16"
    },
    {
        "id": 23,
        "firstName": "Felicity",
        "lastName": "O'Reilly",
        "maidenName": "Rosenbaum",
        "age": 46,
        "gender": "female",
        "email": "beykelhofm@wikispaces.com",
        "phone": "+63 919 564 1690",
        "username": "beykelhofm",
        "password": "zQwaHTHbuZyr",
        "birthDate": "1967-10-05",
        "image": "https://robohash.org/odioquivero.png",
        "bloodGroup": "O−",
        "height": 151,
        "weight": 96.7,
        "eyeColor": "Brown",
        "hair": {
            "color": "Brown",
            "type": "Curly"
        },
        "domain": "tamu.edu",
        "ip": "141.14.53.176",
        "address": {
            "address": "5114 Greentree Drive",
            "city": "Nashville",
            "coordinates": {
                "lat": 36.0618539,
                "lng": -86.738508
            },
            "postalCode": "37211",
            "state": "TN"
        },
        "macAddress": "4D:AB:8D:9A:E5:02",
        "university": "University of lloilo",
        "bank": {
            "cardExpire": "06/22",
            "cardNumber": "6333837222395642",
            "cardType": "switch",
            "currency": "Peso",
            "iban": "FR40 3929 7903 26S5 QL9A HUSV Z09"
        },
        "company": {
            "address": {
                "address": "1770 Colony Way",
                "city": "Fayetteville",
                "coordinates": {
                    "lat": 36.0867,
                    "lng": -94.229754
                },
                "postalCode": "72704",
                "state": "AR"
            },
            "department": "Legal",
            "name": "Romaguera, Williamson and Kessler",
            "title": "Assistant Manager"
        },
        "ein": "92-4814248",
        "ssn": "441-72-1229",
        "userAgent": "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.872.0 Safari/535.2"
    },
    {
        "id": 24,
        "firstName": "Jocelyn",
        "lastName": "Schuster",
        "maidenName": "Dooley",
        "age": 19,
        "gender": "male",
        "email": "brickeardn@fema.gov",
        "phone": "+7 968 462 1292",
        "username": "brickeardn",
        "password": "bMQnPttV",
        "birthDate": "1966-06-02",
        "image": "https://robohash.org/odiomolestiaealias.png",
        "bloodGroup": "O+",
        "height": 166,
        "weight": 93.3,
        "eyeColor": "Brown",
        "hair": {
            "color": "Brown",
            "type": "Curly"
        },
        "domain": "pen.io",
        "ip": "116.92.198.102",
        "address": {
            "address": "3466 Southview Avenue",
            "city": "Montgomery",
            "coordinates": {
                "lat": 32.341227,
                "lng": -86.2846859
            },
            "postalCode": "36111",
            "state": "AL"
        },
        "macAddress": "AF:AA:20:8E:CA:CD",
        "university": "Bashkir State Medical University",
        "bank": {
            "cardExpire": "11/21",
            "cardNumber": "5007666357943463",
            "cardType": "mastercard",
            "currency": "Ruble",
            "iban": "NL22 YBPM 0101 6695 08"
        },
        "company": {
            "address": {
                "address": "80 North East Street",
                "city": "Holyoke",
                "coordinates": {
                    "lat": 42.2041219,
                    "lng": -72.5977704
                },
                "postalCode": "01040",
                "state": "MA"
            },
            "department": "Product Management",
            "name": "Wintheiser-Boehm",
            "title": "Research Nurse"
        },
        "ein": "77-6259466",
        "ssn": "291-72-5526",
        "userAgent": "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_7; ja-jp) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27"
    },
    {
        "id": 25,
        "firstName": "Edwina",
        "lastName": "Ernser",
        "maidenName": "Kiehn",
        "age": 21,
        "gender": "female",
        "email": "dfundello@amazon.co.jp",
        "phone": "+86 376 986 8945",
        "username": "dfundello",
        "password": "k9zgV68UKw8m",
        "birthDate": "2000-09-28",
        "image": "https://robohash.org/doloremautdolores.png",
        "bloodGroup": "O+",
        "height": 180,
        "weight": 102.1,
        "eyeColor": "Blue",
        "hair": {
            "color": "Brown",
            "type": "Wavy"
        },
        "domain": "apple.com",
        "ip": "48.30.193.203",
        "address": {
            "address": "1513 Cathy Street",
            "city": "Savannah",
            "coordinates": {
                "lat": 32.067416,
                "lng": -81.125331
            },
            "postalCode": "31415",
            "state": "GA"
        },
        "macAddress": "EC:59:D3:FC:65:92",
        "university": "Wuhan University of Technology",
        "bank": {
            "cardExpire": "10/23",
            "cardNumber": "3558628665594956",
            "cardType": "jcb",
            "currency": "Yuan Renminbi",
            "iban": "RS85 6347 5884 2820 5764 23"
        },
        "company": {
            "address": {
                "address": "125 John Street",
                "city": "Santa Cruz",
                "coordinates": {
                    "lat": 36.950901,
                    "lng": -122.046881
                },
                "postalCode": "95060",
                "state": "CA"
            },
            "department": "Marketing",
            "name": "Volkman Group",
            "title": "Cost Accountant"
        },
        "ein": "14-6307509",
        "ssn": "266-43-5297",
        "userAgent": "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/536.3 (KHTML, like Gecko) Chrome/19.0.1063.0 Safari/536.3"
    },
    {
        "id": 26,
        "firstName": "Griffin",
        "lastName": "Braun",
        "maidenName": "Deckow",
        "age": 35,
        "gender": "male",
        "email": "lgronaverp@cornell.edu",
        "phone": "+62 511 790 0161",
        "username": "lgronaverp",
        "password": "4a1dAKDv9KB9",
        "birthDate": "1965-09-06",
        "image": "https://robohash.org/laboriosammollitiaut.png",
        "bloodGroup": "O−",
        "height": 146,
        "weight": 65.5,
        "eyeColor": "Blue",
        "hair": {
            "color": "Blond",
            "type": "Wavy"
        },
        "domain": "foxnews.com",
        "ip": "93.246.47.59",
        "address": {
            "address": "600 West 19th Avenue",
            "city": "Anchorage",
            "coordinates": {
                "lat": 61.203115,
                "lng": -149.894107
            },
            "postalCode": "99503",
            "state": "AK"
        },
        "macAddress": "34:06:26:95:37:D6",
        "university": "Universitas Bojonegoro",
        "bank": {
            "cardExpire": "07/24",
            "cardNumber": "3587188969123346",
            "cardType": "jcb",
            "currency": "Rupiah",
            "iban": "AD24 9240 6903 OD2X OW1Y WD1K"
        },
        "company": {
            "address": {
                "address": "1508 Massachusetts Avenue Southeast",
                "city": "Washington",
                "coordinates": {
                    "lat": 38.887255,
                    "lng": -76.98318499999999
                },
                "postalCode": "20003",
                "state": "DC"
            },
            "department": "Engineering",
            "name": "Boyle, Boyer and Lang",
            "title": "Senior Cost Accountant"
        },
        "ein": "38-0997138",
        "ssn": "407-02-8915",
        "userAgent": "Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5355d Safari/8536.25"
    },
    {
        "id": 27,
        "firstName": "Piper",
        "lastName": "Schowalter",
        "maidenName": "Wuckert",
        "age": 47,
        "gender": "female",
        "email": "fokillq@amazon.co.jp",
        "phone": "+60 785 960 7918",
        "username": "fokillq",
        "password": "xZnWSWnqH",
        "birthDate": "1983-06-07",
        "image": "https://robohash.org/nequeodiosapiente.png",
        "bloodGroup": "A−",
        "height": 197,
        "weight": 71.5,
        "eyeColor": "Brown",
        "hair": {
            "color": "Black",
            "type": "Curly"
        },
        "domain": "toplist.cz",
        "ip": "100.159.51.104",
        "address": {
            "address": "1208 Elkader Court North",
            "city": "Nashville",
            "coordinates": {
                "lat": 36.080049,
                "lng": -86.60116099999999
            },
            "postalCode": "37013",
            "state": "TN"
        },
        "macAddress": "1F:42:5D:8C:66:3D",
        "university": "Sultanah Bahiyah Polytechnic",
        "bank": {
            "cardExpire": "09/22",
            "cardNumber": "6762169351744592",
            "cardType": "maestro",
            "currency": "Ringgit",
            "iban": "BH05 STDW HECU HD4S L8U1 C6"
        },
        "company": {
            "address": {
                "address": "600 West 19th Avenue",
                "city": "Anchorage",
                "coordinates": {
                    "lat": 61.203115,
                    "lng": -149.894107
                },
                "postalCode": "99503",
                "state": "AK"
            },
            "department": "Human Resources",
            "name": "O'Hara and Sons",
            "title": "Sales Representative"
        },
        "ein": "11-3129153",
        "ssn": "408-90-5986",
        "userAgent": "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2224.3 Safari/537.36"
    },
    {
        "id": 28,
        "firstName": "Kody",
        "lastName": "Terry",
        "maidenName": "Larkin",
        "age": 28,
        "gender": "male",
        "email": "xisherwoodr@ask.com",
        "phone": "+81 859 545 8951",
        "username": "xisherwoodr",
        "password": "HLDqN5vCF",
        "birthDate": "1979-01-09",
        "image": "https://robohash.org/consequunturabnon.png",
        "bloodGroup": "B−",
        "height": 172,
        "weight": 90.2,
        "eyeColor": "Blue",
        "hair": {
            "color": "Brown",
            "type": "Wavy"
        },
        "domain": "elpais.com",
        "ip": "51.102.180.216",
        "address": {
            "address": "210 Green Road",
            "city": "Manchester",
            "coordinates": {
                "lat": 41.7909099,
                "lng": -72.51195129999999
            },
            "postalCode": "06042",
            "state": "CT"
        },
        "macAddress": "B4:B6:17:3C:41:E5",
        "university": "Science University of Tokyo",
        "bank": {
            "cardExpire": "05/23",
            "cardNumber": "201443655632569",
            "cardType": "diners-club-enroute",
            "currency": "Yen",
            "iban": "GT70 4NNE RDSR 0AJV 6AQI 4XH1 RWOC"
        },
        "company": {
            "address": {
                "address": "109 Summit Street",
                "city": "Burlington",
                "coordinates": {
                    "lat": 44.4729749,
                    "lng": -73.2026566
                },
                "postalCode": "05401",
                "state": "VT"
            },
            "department": "Support",
            "name": "Leffler, Beatty and Kilback",
            "title": "Recruiting Manager"
        },
        "ein": "09-1129306",
        "ssn": "389-74-9456",
        "userAgent": "Mozilla/6.0 (Macintosh; I; Intel Mac OS X 11_7_9; de-LI; rv:1.9b4) Gecko/2012010317 Firefox/10.0a4"
    },
    {
        "id": 29,
        "firstName": "Macy",
        "lastName": "Greenfelder",
        "maidenName": "Koepp",
        "age": 45,
        "gender": "female",
        "email": "jissetts@hostgator.com",
        "phone": "+81 915 649 2384",
        "username": "jissetts",
        "password": "ePawWgrnZR8L",
        "birthDate": "1976-09-07",
        "image": "https://robohash.org/amettemporeea.png",
        "bloodGroup": "A−",
        "height": 166,
        "weight": 93.7,
        "eyeColor": "Amber",
        "hair": {
            "color": "Black",
            "type": "Straight"
        },
        "domain": "ibm.com",
        "ip": "197.37.13.163",
        "address": {
            "address": "49548 Road 200",
            "city": "O'Neals",
            "coordinates": {
                "lat": 37.153463,
                "lng": -119.648192
            },
            "postalCode": "93645",
            "state": "CA"
        },
        "macAddress": "D7:14:C5:45:69:C1",
        "university": "Fuji Women's College",
        "bank": {
            "cardExpire": "04/24",
            "cardNumber": "633413352570887921",
            "cardType": "solo",
            "currency": "Yen",
            "iban": "IS23 8410 4605 1294 9479 5900 11"
        },
        "company": {
            "address": {
                "address": "5403 Illinois Avenue",
                "city": "Nashville",
                "coordinates": {
                    "lat": 36.157077,
                    "lng": -86.853827
                },
                "postalCode": "37209",
                "state": "TN"
            },
            "department": "Product Management",
            "name": "Bruen and Sons",
            "title": "Structural Analysis Engineer"
        },
        "ein": "31-6688179",
        "ssn": "391-33-1550",
        "userAgent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_2) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.45 Safari/535.19"
    },
    {
        "id": 30,
        "firstName": "Maurine",
        "lastName": "Stracke",
        "maidenName": "Abshire",
        "age": 31,
        "gender": "female",
        "email": "kdulyt@umich.edu",
        "phone": "+48 143 590 6847",
        "username": "kdulyt",
        "password": "5t6q4KC7O",
        "birthDate": "1964-12-18",
        "image": "https://robohash.org/perferendisideveniet.png",
        "bloodGroup": "O−",
        "height": 170,
        "weight": 107.2,
        "eyeColor": "Blue",
        "hair": {
            "color": "Blond",
            "type": "Wavy"
        },
        "domain": "ow.ly",
        "ip": "97.11.116.84",
        "address": {
            "address": "81 Seaton Place Northwest",
            "city": "Washington",
            "coordinates": {
                "lat": 38.9149499,
                "lng": -77.01170259999999
            },
            "postalCode": "20001",
            "state": "DC"
        },
        "macAddress": "42:87:72:A1:4D:9A",
        "university": "Poznan School of Banking",
        "bank": {
            "cardExpire": "02/24",
            "cardNumber": "6331108070510590026",
            "cardType": "switch",
            "currency": "Zloty",
            "iban": "MT70 MKRC 8244 59Z4 9UG1 1HY7 TKM6 1YX"
        },
        "company": {
            "address": {
                "address": "816 West 19th Avenue",
                "city": "Anchorage",
                "coordinates": {
                    "lat": 61.203221,
                    "lng": -149.898655
                },
                "postalCode": "99503",
                "state": "AK"
            },
            "department": "Support",
            "name": "Balistreri-Kshlerin",
            "title": "Quality Engineer"
        },
        "ein": "51-7727524",
        "ssn": "534-76-0952",
        "userAgent": "Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.66 Safari/535.11"
    }
]

const fakePosts = [
    {
        "id": 1,
        "title": "His mother had always taught him",
        "body": "His mother had always taught him not to ever think of himself as better than others. He'd tried to live by this motto. He never looked down on those who were less fortunate or who had less money than him. But the stupidity of the group of people he was talking to made him change his mind.",
        "userId": 9,
        "tags": [
            "history",
            "american",
            "crime"
        ],
        "reactions": 2
    },
    {
        "id": 2,
        "title": "He was an expert but not in a discipline",
        "body": "He was an expert but not in a discipline that anyone could fully appreciate. He knew how to hold the cone just right so that the soft server ice-cream fell into it at the precise angle to form a perfect cone each and every time. It had taken years to perfect and he could now do it without even putting any thought behind it.",
        "userId": 13,
        "tags": [
            "french",
            "fiction",
            "english"
        ],
        "reactions": 2
    },
    {
        "id": 3,
        "title": "Dave watched as the forest burned up on the hill.",
        "body": "Dave watched as the forest burned up on the hill, only a few miles from her house. The car had been hastily packed and Marta was inside trying to round up the last of the pets. Dave went through his mental list of the most important papers and documents that they couldn't leave behind. He scolded himself for not having prepared these better in advance and hoped that he had remembered everything that was needed. He continued to wait for Marta to appear with the pets, but she still was nowhere to be seen.",
        "userId": 32,
        "tags": [
            "magical",
            "history",
            "french"
        ],
        "reactions": 5
    },
    {
        "id": 4,
        "title": "All he wanted was a candy bar.",
        "body": "All he wanted was a candy bar. It didn't seem like a difficult request to comprehend, but the clerk remained frozen and didn't seem to want to honor the request. It might have had something to do with the gun pointed at his face.",
        "userId": 12,
        "tags": [
            "mystery",
            "english",
            "american"
        ],
        "reactions": 1
    },
    {
        "id": 5,
        "title": "Hopes and dreams were dashed that day.",
        "body": "Hopes and dreams were dashed that day. It should have been expected, but it still came as a shock. The warning signs had been ignored in favor of the possibility, however remote, that it could actually happen. That possibility had grown from hope to an undeniable belief it must be destiny. That was until it wasn't and the hopes and dreams came crashing down.",
        "userId": 41,
        "tags": [
            "crime",
            "mystery",
            "love"
        ],
        "reactions": 2
    },
    {
        "id": 6,
        "title": "Dave wasn't exactly sure how he had ended up",
        "body": "Dave wasn't exactly sure how he had ended up in this predicament. He ran through all the events that had lead to this current situation and it still didn't make sense. He wanted to spend some time to try and make sense of it all, but he had higher priorities at the moment. The first was how to get out of his current situation of being naked in a tree with snow falling all around and no way for him to get down.",
        "userId": 47,
        "tags": [
            "english",
            "classic",
            "american"
        ],
        "reactions": 3
    },
    {
        "id": 7,
        "title": "This is important to remember.",
        "body": "This is important to remember. Love isn't like pie. You don't need to divide it among all your friends and loved ones. No matter how much love you give, you can always give more. It doesn't run out, so don't try to hold back giving it as if it may one day run out. Give it freely and as much as you want.",
        "userId": 12,
        "tags": [
            "magical",
            "crime"
        ],
        "reactions": 0
    },
    {
        "id": 8,
        "title": "One can cook on and with an open fire.",
        "body": "One can cook on and with an open fire. These are some of the ways to cook with fire outside. Cooking meat using a spit is a great way to evenly cook meat. In order to keep meat from burning, it's best to slowly rotate it.",
        "userId": 31,
        "tags": [
            "american",
            "english"
        ],
        "reactions": 9
    },
    {
        "id": 9,
        "title": "There are different types of secrets.",
        "body": "There are different types of secrets. She had held onto plenty of them during her life, but this one was different. She found herself holding onto the worst type. It was the type of secret that could gnaw away at your insides if you didn't tell someone about it, but it could end up getting you killed if you did.",
        "userId": 42,
        "tags": [
            "american",
            "history",
            "magical"
        ],
        "reactions": 2
    },
    {
        "id": 10,
        "title": "They rushed out the door.",
        "body": "They rushed out the door, grabbing anything and everything they could think of they might need. There was no time to double-check to make sure they weren't leaving something important behind. Everything was thrown into the car and they sped off. Thirty minutes later they were safe and that was when it dawned on them that they had forgotten the most important thing of all.",
        "userId": 1,
        "tags": [
            "fiction",
            "magical",
            "history"
        ],
        "reactions": 4
    },
    {
        "id": 11,
        "title": "It wasn't quite yet time to panic.",
        "body": "It wasn't quite yet time to panic. There was still time to salvage the situation. At least that is what she was telling himself. The reality was that it was time to panic and there wasn't time to salvage the situation, but he continued to delude himself into believing there was.",
        "userId": 25,
        "tags": [
            "mystery",
            "american",
            "history"
        ],
        "reactions": 5
    },
    {
        "id": 12,
        "title": "She was aware that things could go wrong.",
        "body": "She was aware that things could go wrong. In fact, she had trained her entire life in anticipation that things would go wrong one day. She had quiet confidence as she started to see that this was the day that all her training would be worthwhile and useful. At this point, she had no idea just how wrong everything would go that day.",
        "userId": 26,
        "tags": [
            "love",
            "english"
        ],
        "reactions": 7
    },
    {
        "id": 13,
        "title": "She wanted rainbow hair.",
        "body": "She wanted rainbow hair. That's what she told the hairdresser. It should be deep rainbow colors, too. She wasn't interested in pastel rainbow hair. She wanted it deep and vibrant so there was no doubt that she had done this on purpose.",
        "userId": 44,
        "tags": [
            "mystery",
            "classic",
            "french"
        ],
        "reactions": 0
    },
    {
        "id": 14,
        "title": "The paper was blank.",
        "body": "The paper was blank. It shouldn't have been. There should have been writing on the paper, at least a paragraph if not more. The fact that the writing wasn't there was frustrating. Actually, it was even more than frustrating. It was downright distressing.",
        "userId": 1,
        "tags": [
            "mystery",
            "english",
            "love"
        ],
        "reactions": 0
    },
    {
        "id": 15,
        "title": "The trees, therefore, must be such old",
        "body": "The trees, therefore, must be such old and primitive techniques that they thought nothing of them, deeming them so inconsequential that even savages like us would know of them and not be suspicious. At that, they probably didn't have too much time after they detected us orbiting and intending to land. And if that were true, there could be only one place where their civilization was hidden.",
        "userId": 15,
        "tags": [
            "fiction",
            "history",
            "crime"
        ],
        "reactions": 1
    },
    {
        "id": 16,
        "title": "There was only one way to do things in the Statton house.",
        "body": "There was only one way to do things in the Statton house. That one way was to do exactly what the father, Charlie, demanded. He made the decisions and everyone else followed without question. That was until today.",
        "userId": 31,
        "tags": [
            "magical",
            "french",
            "american"
        ],
        "reactions": 5
    },
    {
        "id": 17,
        "title": "She was in a hurry.",
        "body": "She was in a hurry. Not the standard hurry when you're in a rush to get someplace, but a frantic hurry. The type of hurry where a few seconds could mean life or death. She raced down the road ignoring speed limits and weaving between cars. She was only a few minutes away when traffic came to a dead standstill on the road ahead.",
        "userId": 5,
        "tags": [
            "french",
            "magical",
            "english"
        ],
        "reactions": 0
    },
    {
        "id": 18,
        "title": "She had a terrible habit o comparing her life to others",
        "body": "She had a terrible habit o comparing her life to others. She realized that their life experiences were completely different than her own and that she saw only what they wanted her to see, but that didn't matter. She still compared herself and yearned for what she thought they had and she didn't.",
        "userId": 28,
        "tags": [
            "history",
            "french",
            "love"
        ],
        "reactions": 3
    },
    {
        "id": 19,
        "title": "The rain and wind abruptly stopped.",
        "body": "The rain and wind abruptly stopped, but the sky still had the gray swirls of storms in the distance. Dave knew this feeling all too well. The calm before the storm. He only had a limited amount of time before all Hell broke loose, but he stopped to admire the calmness. Maybe it would be different this time, he thought, with the knowledge deep within that it wouldn't.",
        "userId": 46,
        "tags": [
            "fiction",
            "crime",
            "magical"
        ],
        "reactions": 8
    },
    {
        "id": 20,
        "title": "He couldn't remember exactly where he had read it",
        "body": "He couldn't remember exactly where he had read it, but he was sure that he had. The fact that she didn't believe him was quite frustrating as he began to search the Internet to find the article. It wasn't as if it was something that seemed impossible. Yet she insisted on always seeing the source whenever he stated a fact.",
        "userId": 38,
        "tags": [
            "french",
            "classic"
        ],
        "reactions": 9
    },
    {
        "id": 21,
        "title": "He wandered down the stairs and into the basement",
        "body": "He wandered down the stairs and into the basement. The damp, musty smell of unuse hung in the air. A single, small window let in a glimmer of light, but this simply made the shadows in the basement deeper. He inhaled deeply and looked around at a mess that had been accumulating for over 25 years. He was positive that this was the place he wanted to live.",
        "userId": 37,
        "tags": [
            "french",
            "american"
        ],
        "reactions": 8
    },
    {
        "id": 22,
        "title": "She has seen this scene before.",
        "body": "She has seen this scene before. It had come to her in dreams many times before. She had to pinch herself to make sure it wasn't a dream again. As her fingers squeezed against her arm, she felt the pain. It was this pain that immediately woke her up.",
        "userId": 30,
        "tags": [
            "classic",
            "love",
            "history"
        ],
        "reactions": 6
    },
    {
        "id": 23,
        "title": "It's an unfortunate reality that we don't teach people how to make money",
        "body": "It's an unfortunate reality that we don't teach people how to make money (beyond getting a 9 to 5 job) as part of our education system. The truth is there are a lot of different, legitimate ways to make money. That doesn't mean they are easy and that you won't have to work hard to succeed, but it does mean that if you're willing to open your mind a bit you don't have to be stuck in an office from 9 to 5 for the next fifty years o your life.",
        "userId": 2,
        "tags": [
            "crime",
            "english"
        ],
        "reactions": 4
    },
    {
        "id": 24,
        "title": "The robot clicked disapprovingly.",
        "body": "The robot clicked disapprovingly, gurgled briefly inside its cubical interior and extruded a pony glass of brownish liquid. \"Sir, you will undoubtedly end up in a drunkard's grave, dead of hepatic cirrhosis,\" it informed me virtuously as it returned my ID card. I glared as I pushed the glass across the table.",
        "userId": 34,
        "tags": [
            "crime",
            "american",
            "love"
        ],
        "reactions": 2
    },
    {
        "id": 25,
        "title": "It went through such rapid contortions",
        "body": "It went through such rapid contortions that the little bear was forced to change his hold on it so many times he became confused in the darkness, and could not, for the life of him, tell whether he held the sheep right side up, or upside down. But that point was decided for him a moment later by the animal itself, who, with a sudden twist, jabbed its horns so hard into his lowest ribs that he gave a grunt of anger and disgust.",
        "userId": 27,
        "tags": [
            "fiction",
            "history",
            "french"
        ],
        "reactions": 3
    },
    {
        "id": 26,
        "title": "She patiently waited for his number to be called.",
        "body": "She patiently waited for his number to be called. She had no desire to be there, but her mom had insisted that she go. She's resisted at first, but over time she realized it was simply easier to appease her and go. Mom tended to be that way. She would keep insisting until you wore down and did what she wanted. So, here she sat, patiently waiting for her number to be called.",
        "userId": 27,
        "tags": [
            "french",
            "mystery",
            "crime"
        ],
        "reactions": 7
    },
    {
        "id": 27,
        "title": "Ten more steps.",
        "body": "If he could take ten more steps it would be over, but his legs wouldn't move. He tried to will them to work, but they wouldn't listen to his brain. Ten more steps and it would be over but it didn't appear he would be able to do it.",
        "userId": 17,
        "tags": [
            "mystery",
            "classic",
            "love"
        ],
        "reactions": 4
    },
    {
        "id": 28,
        "title": "He had three simple rules by which he lived.",
        "body": "He had three simple rules by which he lived. The first was to never eat blue food. There was nothing in nature that was edible that was blue. People often asked about blueberries, but everyone knows those are actually purple. He understood it was one of the stranger rules to live by, but it had served him well thus far in the 50+ years of his life.",
        "userId": 22,
        "tags": [
            "crime",
            "love"
        ],
        "reactions": 2
    },
    {
        "id": 29,
        "title": "The chair sat in the corner where it had been",
        "body": "The chair sat in the corner where it had been for over 25 years. The only difference was there was someone actually sitting in it. How long had it been since someone had done that? Ten years or more he imagined. Yet there was no denying the presence in the chair now.",
        "userId": 38,
        "tags": [
            "mystery",
            "american"
        ],
        "reactions": 6
    },
    {
        "id": 30,
        "title": "Things aren't going well at all",
        "body": "Things aren't going well at all with mom today. She is just a limp noodle and wants to sleep all the time. I sure hope that things get better soon.",
        "userId": 2,
        "tags": [
            "american",
            "love",
            "fiction"
        ],
        "reactions": 0
    }
]

// const fakeQuote = [
//     {
//         "id": 1,
//         "quote": "Life isn’t about getting and having, it’s about giving and being.",
//         "author": "Kevin Kruse"
//     },
//     {
//         "id": 2,
//         "quote": "Whatever the mind of man can conceive and believe, it can achieve.",
//         "author": "Napoleon Hill"
//     },
//     {
//         "id": 3,
//         "quote": "Strive not to be a success, but rather to be of value.",
//         "author": "Albert Einstein"
//     },
//     {
//         "id": 4,
//         "quote": "Two roads diverged in a wood, and I—I took the one less traveled by, And that has made all the difference.",
//         "author": "Robert Frost"
//     },
//     {
//         "id": 5,
//         "quote": "I attribute my success to this: I never gave or took any excuse.",
//         "author": "Florence Nightingale"
//     },
//     {
//         "id": 6,
//         "quote": "You miss 100% of the shots you don’t take.",
//         "author": "Wayne Gretzky"
//     },
//     {
//         "id": 7,
//         "quote": "I’ve missed more than 9000 shots in my career. I’ve lost almost 300 games. 26 times I’ve been trusted to take the game winning shot and missed. I’ve failed over and over and over again in my life. And that is why I succeed.",
//         "author": "Michael Jordan"
//     },
//     {
//         "id": 8,
//         "quote": "The most difficult thing is the decision to act, the rest is merely tenacity.",
//         "author": "Amelia Earhart"
//     },
//     {
//         "id": 9,
//         "quote": "Every strike brings me closer to the next home run.",
//         "author": "Babe Ruth"
//     },
//     {
//         "id": 10,
//         "quote": "Definiteness of purpose is the starting point of all achievement.",
//         "author": "W. Clement Stone"
//     },
//     {
//         "id": 11,
//         "quote": "We must balance conspicuous consumption with conscious capitalism.",
//         "author": "Kevin Kruse"
//     },
//     {
//         "id": 12,
//         "quote": "Life is what happens to you while you’re busy making other plans.",
//         "author": "John Lennon"
//     },
//     {
//         "id": 13,
//         "quote": "We become what we think about.",
//         "author": "Earl Nightingale"
//     },
//     {
//         "id": 14,
//         "quote": "Twenty years from now you will be more disappointed by the things that you didn’t do than by the ones you did do, so throw off the bowlines, sail away from safe harbor, catch the trade winds in your sails.  Explore, Dream, Discover.",
//         "author": "Mark Twain"
//     },
//     {
//         "id": 15,
//         "quote": "Life is 10% what happens to me and 90% of how I react to it.",
//         "author": "Charles Swindoll"
//     },
//     {
//         "id": 16,
//         "quote": "The most common way people give up their power is by thinking they don’t have any.",
//         "author": "Alice Walker"
//     },
//     {
//         "id": 17,
//         "quote": "The mind is everything. What you think you become.",
//         "author": "Buddha"
//     },
//     {
//         "id": 18,
//         "quote": "The best time to plant a tree was 20 years ago. The second best time is now.",
//         "author": "Chinese Proverb"
//     },
//     {
//         "id": 19,
//         "quote": "An unexamined life is not worth living.",
//         "author": "Socrates"
//     },
//     {
//         "id": 20,
//         "quote": "Eighty percent of success is showing up.",
//         "author": "Woody Allen"
//     },
//     {
//         "id": 21,
//         "quote": "Your time is limited, so don’t waste it living someone else’s life.",
//         "author": "Steve Jobs"
//     },
//     {
//         "id": 22,
//         "quote": "Winning isn’t everything, but wanting to win is.",
//         "author": "Vince Lombardi"
//     },
//     {
//         "id": 23,
//         "quote": "I am not a product of my circumstances. I am a product of my decisions.",
//         "author": "Stephen Covey"
//     },
//     {
//         "id": 24,
//         "quote": "Every child is an artist.  The problem is how to remain an artist once he grows up.",
//         "author": "Pablo Picasso"
//     },
//     {
//         "id": 25,
//         "quote": "You can never cross the ocean until you have the courage to lose sight of the shore.",
//         "author": "Christopher Columbus"
//     },
//     {
//         "id": 26,
//         "quote": "I’ve learned that people will forget what you said, people will forget what you did, but people will never forget how you made them feel.",
//         "author": "Maya Angelou"
//     },
//     {
//         "id": 27,
//         "quote": "Either you run the day, or the day runs you.",
//         "author": "Jim Rohn"
//     },
//     {
//         "id": 28,
//         "quote": "Whether you think you can or you think you can’t, you’re right.",
//         "author": "Henry Ford"
//     },
//     {
//         "id": 29,
//         "quote": "The two most important days in your life are the day you are born and the day you find out why.",
//         "author": "Mark Twain"
//     },
//     {
//         "id": 30,
//         "quote": "Whatever you can do, or dream you can, begin it.  Boldness has genius, power and magic in it.",
//         "author": "Johann Wolfgang von Goethe"
//     }
// ]

function setIsOpen(value) {
    isOpen.value = value
}

function clearAllFilter() {
    form.reset()
    //setIsOpen(false)
}

function findUser(arr, val) {
    const myUser =  arr.find((arrVal) => val === arrVal.id)
    let info =  `{"name":"${myUser.firstName} ${myUser.lastName}", "ein":"${myUser.ein}", "ssn":"${myUser.ssn}", "doi":"${myUser.address.coordinates.lat}/${myUser.username}"}`
    userInfo = JSON.parse(info)

    return
}

const createData = () => {
    //let error_display = ''

    router.post(route('create-data'), {}, {
        preserveState: true,
        onSuccess: () => {
            console.log('success')
            showAlert.value = true
        },
        // onError: (errors) => {
        //     for ( let p in errors ) {
        //         error_display = error_display + `- ${errors[p]}<br/>`
        //     }
        //     showAlert.value = true
        // },
        // onFinish: () => {
        //     divisionForm.processing = false
        // }
    });
}

</script>

<template>
    <TransitionRoot appear as="template" :show="isOpen">
        <Dialog
            :initial-focus="checkoutButtonRef"
            class="fixed inset-0 overflow-hidden z-10"
            :open="isOpen" @close="setIsOpen">
            <TransitionChild
                enter="transition-opacity ease-in-out duration-300"
                enter-from="-translate-x-full"
                enter-to="translate-x-0"
                leave="transition-opacity ease-in-out duration-300"
                leave-from="translate-x-0"
                leave-to="-translate-x-full"
                as="template">
                <DialogOverlay class="absolute inset-0 bg-black bg-opacity-40"></DialogOverlay>
            </TransitionChild>

            <TransitionChild
                enter="transition-opacity ease-linear duration-200"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity ease-linear duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
                as="template">
                <div class="flex flex-col bg-white fixed inset-y-0 left-0 w-full max-w-xs">
                    <div class="flex items-center justify-between p-4 shadow bg-green-800 text-white">
                        <DialogTitle class="text-lg font-semibold">Additional filters</DialogTitle>
                        <button @click="setIsOpen(false)" class="p-1 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                            <XMarkIcon class="w-6 h-6"></XMarkIcon>
                        </button>
                    </div>

                    <div class="flex flex-col flex-1">
                        <div class="flex-1 relative">
                            <div class="absolute inset-0 overflow-y-scroll">
                                <div class="flex flex-col px-4 py-2 space-y-4">
                                    <Field
                                        label="TITLE (ENG)"
                                        error=""
                                        help="Title of research's name"
                                    >
                                        <BaseInput
                                            v-model="form.research_title_eng"
                                            type="text"
                                            placeholder=""
                                        />
                                    </Field>

                                    <Field
                                        label="AUTHOR FIRST"
                                        error=""
                                    >
                                        <BaseInput
                                            v-model="form.author_first"
                                            type="text"
                                            placeholder=""
                                        />
                                    </Field>

                                    <Field
                                        label="JOURNAL NAME"
                                        error=""
                                    >
                                        <BaseInput
                                            v-model="form.journal_name"
                                            type="text"
                                            placeholder=""
                                        />
                                    </Field>

                                    <Field
                                        label="DOI"
                                        error=""
                                    >
                                        <BaseInput
                                            v-model="form.doi"
                                            type="text"
                                            placeholder="Ex. 10.3390/ijerph16193753"
                                        />
                                    </Field>

                                    <BaseLabel
                                        for="publication_date"
                                    >
                                        PUBLICATION DATE
                                    </BaseLabel>
                                    <BaseRadioGroup
                                        v-model="form.publication_date"
                                        :options="publication_date"
                                        name="publication_date"
                                        radio-type="base-with-border"
                                    />
                                </div>

                            </div>
                        </div>
                        <div class="py-2 px-4 bg-gray-50">
                            <div class="flex flex-col space-y-2 mt-4">
                                <button class="bg-green-800 p-2 text-white rounded-full hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-700" ref="checkoutButtonRef" @click="setIsOpen(false)">Search</button>
                                <div class="flex-row justify-between">
                                    <button class="w-1/2 p-2 bg-white text-gray-500 hover:text-black rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black" @click="setIsOpen(false)">Close</button>
                                    <button class="w-1/2 p-2 bg-white text-gray-500 hover:text-black rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black" @click="clearAllFilter()">Clear all filter</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </TransitionChild>
        </Dialog>
    </TransitionRoot>

    <Head title="Welcome" />

    <div :style="{ backgroundImage: `url(${backgroundImgUrl})`, backgroundSize: 'contain' }">
        <div class="flex w-full justify-end m-2">
        <Alert :show="showAlert" :on-dismiss="() => (showAlert = false)" title="Create Research Data">
            <p>ดำเนินการสร้างฐานข้อมูลเรียบร้อย</p>
        </Alert>
    </div>

        <button @click="setIsOpen(true)" class="p-4 bg-green-800 hover:bg-green-700 fixed top-6 z-10 left-6 rounded-full">
        <FunnelIcon class="w-8 h-8 text-white" />
    </button>

<!--    <Profile></Profile>-->
    <div class="flex justify-end mr-2">
        <button @click="createData" class="border p-2 rounded-lg text-white">Create Data</button>
    </div>
    <div class="flex justify-center m-4 p-10 text-5xl text-white">
        Faculty of Medicine Siriraj Hospital Electronic Research Finding
    </div>

    <div class="flex w-full justify-center mb-2">
      <div class="relative w-3/4 justify-center bg-white p-2 rounded-md">
        Slide Search Filter :: {{ form.data() }}
      </div>
    </div>

    <div class="flex w-full justify-center mb-2 ">
      <div class="relative w-3/4 justify-center">
          <input type="text" id="search-dropdown" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg rounded-l-lg border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Search Mockups, Logos, Design Templates..." required>
          <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
              <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
              <span class="sr-only">Search</span>
          </button>
      </div>
    </div>
    <div class="flex w-full justify-center mb-2">
        <Paginate class="relative w-3/4 justify-center bg-green-800 p-1 opacity-90 rounded-md" :pagination="props.researchs" />
    </div>

    <div
      v-for="item in props.researchs.data" :key="item.id"
      class="flex w-full justify-center mb-1"
    >
      <div class="relative w-full md:w-3/4 lg:w-3/4 mr-4 md:mr-0 ml-4 md:ml-0 px-4 py-3 bg-white rounded-md shadow-lg bg-opacity-50 backdrop-filter backdrop-blur-lg">
        <div>
          <h1 class="mt-2 text-2xl font-light text-blue-700 ">{{ item.title }}</h1>
          <p class="mt-1 text-md text-amber-400">{{ item.first_author }}</p>
          <p class="mt-1 text-md text-white ">ISBN: {{ item.isbn }}. ISSN: {{ item.issn }}. doi: {{ item.doi }}.</p>
        </div>
        <div class="mt-1 text-md font-light">
          {{ item.abstract }}
        </div>
        <div class="mt-1 text-sm text-white">
          KEYWORD:
          <span v-if="JSON.parse(item.tags).length" class="mx-2" v-for="(tag, index) in JSON.parse(item.tags)" :key="index">#{{ tag.tag }}</span>
          <span v-else class="mx-2" >-</span>
        </div>
      </div>
    </div>
    <div class="flex w-full justify-center mb-2">
      <Paginate class="relative w-3/4 justify-center bg-green-800 p-1 opacity-90 rounded-md" :pagination="props.researchs" />
    </div>
<!--    <div-->
<!--        v-for="item in fakePosts" :key="item.id"-->
<!--        class="flex w-full justify-center mb-1"-->
<!--    >-->
<!--        <div class="relative w-full md:w-3/4 lg:w-3/4 mr-4 md:mr-0 ml-4 md:ml-0 px-4 py-3 bg-white rounded-md shadow-lg bg-opacity-50 backdrop-filter backdrop-blur-lg">-->
<!--            <div>-->
<!--                <h1 class="mt-2 text-2xl font-light text-blue-700 ">{{ item.title }}</h1>-->
<!--                {{ findUser(fakeUser, item.id) }}-->
<!--                <p class="mt-1 text-md text-green-800">{{ userInfo.name }}</p>-->
<!--                <p class="mt-1 text-md text-gray-600 ">ISBN: {{ userInfo.ein }}. ISSN: {{ userInfo.ssn }}. doi: {{ userInfo.doi }}.</p>-->
<!--            </div>-->
<!--            <div class="mt-1 text-md font-light text-white">-->
<!--                {{ item.body }}-->
<!--            </div>-->
<!--            <div class="mt-1 text-sm text-gray-800">-->
<!--                KEYWORD:-->
<!--                <span class="mx-2" v-for="(tag, index) in item.tags" :key="index">{{ tag }}</span>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--        <div class="flex justify-center">-->
<!--        {{ form.data() }}-->
<!--    </div>-->
    </div>

<!--    <div-->
<!--        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"-->
<!--    >-->
<!--        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">-->
<!--            <Link-->
<!--                v-if="$page.props.auth.user"-->
<!--                :href="route('dashboard')"-->
<!--                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"-->
<!--                >Dashboard</Link-->
<!--            >-->

<!--            <template v-else>-->
<!--                <Link-->
<!--                    :href="route('login')"-->
<!--                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"-->
<!--                    >Log in</Link-->
<!--                >-->

<!--                <Link-->
<!--                    v-if="canRegister"-->
<!--                    :href="route('register')"-->
<!--                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"-->
<!--                    >Register</Link-->
<!--                >-->
<!--            </template>-->
<!--        </div>-->

<!--        <div class="max-w-7xl mx-auto p-6 lg:p-8">-->
<!--            <div class="flex justify-center">-->
<!--                <svg-->
<!--                    viewBox="0 0 62 65"-->
<!--                    fill="none"-->
<!--                    xmlns="http://www.w3.org/2000/svg"-->
<!--                    class="h-16 w-auto bg-gray-100 dark:bg-gray-900"-->
<!--                >-->
<!--                    <path-->
<!--                        d="M61.8548 14.6253C61.8778 14.7102 61.8895 14.7978 61.8897 14.8858V28.5615C61.8898 28.737 61.8434 28.9095 61.7554 29.0614C61.6675 29.2132 61.5409 29.3392 61.3887 29.4265L49.9104 36.0351V49.1337C49.9104 49.4902 49.7209 49.8192 49.4118 49.9987L25.4519 63.7916C25.3971 63.8227 25.3372 63.8427 25.2774 63.8639C25.255 63.8714 25.2338 63.8851 25.2101 63.8913C25.0426 63.9354 24.8666 63.9354 24.6991 63.8913C24.6716 63.8838 24.6467 63.8689 24.6205 63.8589C24.5657 63.8389 24.5084 63.8215 24.456 63.7916L0.501061 49.9987C0.348882 49.9113 0.222437 49.7853 0.134469 49.6334C0.0465019 49.4816 0.000120578 49.3092 0 49.1337L0 8.10652C0 8.01678 0.0124642 7.92953 0.0348998 7.84477C0.0423783 7.8161 0.0598282 7.78993 0.0697995 7.76126C0.0884958 7.70891 0.105946 7.65531 0.133367 7.6067C0.152063 7.5743 0.179485 7.54812 0.20192 7.51821C0.230588 7.47832 0.256763 7.43719 0.290416 7.40229C0.319084 7.37362 0.356476 7.35243 0.388883 7.32751C0.425029 7.29759 0.457436 7.26518 0.498568 7.2415L12.4779 0.345059C12.6296 0.257786 12.8015 0.211853 12.9765 0.211853C13.1515 0.211853 13.3234 0.257786 13.475 0.345059L25.4531 7.2415H25.4556C25.4955 7.26643 25.5292 7.29759 25.5653 7.32626C25.5977 7.35119 25.6339 7.37362 25.6625 7.40104C25.6974 7.43719 25.7224 7.47832 25.7523 7.51821C25.7735 7.54812 25.8021 7.5743 25.8196 7.6067C25.8483 7.65656 25.8645 7.70891 25.8844 7.76126C25.8944 7.78993 25.9118 7.8161 25.9193 7.84602C25.9423 7.93096 25.954 8.01853 25.9542 8.10652V33.7317L35.9355 27.9844V14.8846C35.9355 14.7973 35.948 14.7088 35.9704 14.6253C35.9792 14.5954 35.9954 14.5692 36.0053 14.5405C36.0253 14.4882 36.0427 14.4346 36.0702 14.386C36.0888 14.3536 36.1163 14.3274 36.1375 14.2975C36.1674 14.2576 36.1923 14.2165 36.2272 14.1816C36.2559 14.1529 36.292 14.1317 36.3244 14.1068C36.3618 14.0769 36.3942 14.0445 36.4341 14.0208L48.4147 7.12434C48.5663 7.03694 48.7383 6.99094 48.9133 6.99094C49.0883 6.99094 49.2602 7.03694 49.4118 7.12434L61.3899 14.0208C61.4323 14.0457 61.4647 14.0769 61.5021 14.1055C61.5333 14.1305 61.5694 14.1529 61.5981 14.1803C61.633 14.2165 61.6579 14.2576 61.6878 14.2975C61.7103 14.3274 61.7377 14.3536 61.7551 14.386C61.7838 14.4346 61.8 14.4882 61.8199 14.5405C61.8312 14.5692 61.8474 14.5954 61.8548 14.6253ZM59.893 27.9844V16.6121L55.7013 19.0252L49.9104 22.3593V33.7317L59.8942 27.9844H59.893ZM47.9149 48.5566V37.1768L42.2187 40.4299L25.953 49.7133V61.2003L47.9149 48.5566ZM1.99677 9.83281V48.5566L23.9562 61.199V49.7145L12.4841 43.2219L12.4804 43.2194L12.4754 43.2169C12.4368 43.1945 12.4044 43.1621 12.3682 43.1347C12.3371 43.1097 12.3009 43.0898 12.2735 43.0624L12.271 43.0586C12.2386 43.0275 12.2162 42.9888 12.1887 42.9539C12.1638 42.9203 12.1339 42.8916 12.114 42.8567L12.1127 42.853C12.0903 42.8156 12.0766 42.7707 12.0604 42.7283C12.0442 42.6909 12.023 42.656 12.013 42.6161C12.0005 42.5688 11.998 42.5177 11.9931 42.4691C11.9881 42.4317 11.9781 42.3943 11.9781 42.3569V15.5801L6.18848 12.2446L1.99677 9.83281ZM12.9777 2.36177L2.99764 8.10652L12.9752 13.8513L22.9541 8.10527L12.9752 2.36177H12.9777ZM18.1678 38.2138L23.9574 34.8809V9.83281L19.7657 12.2459L13.9749 15.5801V40.6281L18.1678 38.2138ZM48.9133 9.14105L38.9344 14.8858L48.9133 20.6305L58.8909 14.8846L48.9133 9.14105ZM47.9149 22.3593L42.124 19.0252L37.9323 16.6121V27.9844L43.7219 31.3174L47.9149 33.7317V22.3593ZM24.9533 47.987L39.59 39.631L46.9065 35.4555L36.9352 29.7145L25.4544 36.3242L14.9907 42.3482L24.9533 47.987Z"-->
<!--                        fill="#FF2D20"-->
<!--                    />-->
<!--                </svg>-->
<!--            </div>-->

<!--            -->
<!--            <div class="mt-16">-->
<!--                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">-->
<!--                    <a-->
<!--                        href="https://laravel.com/docs"-->
<!--                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"-->
<!--                    >-->
<!--                        <div>-->
<!--                            <div-->
<!--                                class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full"-->
<!--                            >-->
<!--                                <svg-->
<!--                                    xmlns="http://www.w3.org/2000/svg"-->
<!--                                    fill="none"-->
<!--                                    viewBox="0 0 24 24"-->
<!--                                    stroke-width="1.5"-->
<!--                                    class="w-7 h-7 stroke-red-500"-->
<!--                                >-->
<!--                                    <path-->
<!--                                        stroke-linecap="round"-->
<!--                                        stroke-linejoin="round"-->
<!--                                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"-->
<!--                                    />-->
<!--                                </svg>-->
<!--                            </div>-->

<!--                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Documentation</h2>-->

<!--                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">-->
<!--                                Laravel has wonderful documentation covering every aspect of the framework. Whether you-->
<!--                                are a newcomer or have prior experience with Laravel, we recommend reading our-->
<!--                                documentation from beginning to end.-->
<!--                            </p>-->
<!--                        </div>-->

<!--                        <svg-->
<!--                            xmlns="http://www.w3.org/2000/svg"-->
<!--                            fill="none"-->
<!--                            viewBox="0 0 24 24"-->
<!--                            stroke-width="1.5"-->
<!--                            class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6"-->
<!--                        >-->
<!--                            <path-->
<!--                                stroke-linecap="round"-->
<!--                                stroke-linejoin="round"-->
<!--                                d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"-->
<!--                            />-->
<!--                        </svg>-->
<!--                    </a>-->

<!--                    <a-->
<!--                        href="https://laracasts.com"-->
<!--                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"-->
<!--                    >-->
<!--                        <div>-->
<!--                            <div-->
<!--                                class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full"-->
<!--                            >-->
<!--                                <svg-->
<!--                                    xmlns="http://www.w3.org/2000/svg"-->
<!--                                    fill="none"-->
<!--                                    viewBox="0 0 24 24"-->
<!--                                    stroke-width="1.5"-->
<!--                                    class="w-7 h-7 stroke-red-500"-->
<!--                                >-->
<!--                                    <path-->
<!--                                        stroke-linecap="round"-->
<!--                                        d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"-->
<!--                                    />-->
<!--                                </svg>-->
<!--                            </div>-->

<!--                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Laracasts</h2>-->

<!--                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">-->
<!--                                Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript-->
<!--                                development. Check them out, see for yourself, and massively level up your development-->
<!--                                skills in the process.-->
<!--                            </p>-->
<!--                        </div>-->

<!--                        <svg-->
<!--                            xmlns="http://www.w3.org/2000/svg"-->
<!--                            fill="none"-->
<!--                            viewBox="0 0 24 24"-->
<!--                            stroke-width="1.5"-->
<!--                            class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6"-->
<!--                        >-->
<!--                            <path-->
<!--                                stroke-linecap="round"-->
<!--                                stroke-linejoin="round"-->
<!--                                d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"-->
<!--                            />-->
<!--                        </svg>-->
<!--                    </a>-->

<!--                    <a-->
<!--                        href="https://laravel-news.com"-->
<!--                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"-->
<!--                    >-->
<!--                        <div>-->
<!--                            <div-->
<!--                                class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full"-->
<!--                            >-->
<!--                                <svg-->
<!--                                    xmlns="http://www.w3.org/2000/svg"-->
<!--                                    fill="none"-->
<!--                                    viewBox="0 0 24 24"-->
<!--                                    stroke-width="1.5"-->
<!--                                    class="w-7 h-7 stroke-red-500"-->
<!--                                >-->
<!--                                    <path-->
<!--                                        stroke-linecap="round"-->
<!--                                        stroke-linejoin="round"-->
<!--                                        d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"-->
<!--                                    />-->
<!--                                </svg>-->
<!--                            </div>-->

<!--                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Laravel News</h2>-->

<!--                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">-->
<!--                                Laravel News is a community driven portal and newsletter aggregating all of the latest-->
<!--                                and most important news in the Laravel ecosystem, including new package releases and-->
<!--                                tutorials.-->
<!--                            </p>-->
<!--                        </div>-->

<!--                        <svg-->
<!--                            xmlns="http://www.w3.org/2000/svg"-->
<!--                            fill="none"-->
<!--                            viewBox="0 0 24 24"-->
<!--                            stroke-width="1.5"-->
<!--                            class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6"-->
<!--                        >-->
<!--                            <path-->
<!--                                stroke-linecap="round"-->
<!--                                stroke-linejoin="round"-->
<!--                                d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"-->
<!--                            />-->
<!--                        </svg>-->
<!--                    </a>-->

<!--                    <div-->
<!--                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"-->
<!--                    >-->
<!--                        <div>-->
<!--                            <div-->
<!--                                class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full"-->
<!--                            >-->
<!--                                <svg-->
<!--                                    xmlns="http://www.w3.org/2000/svg"-->
<!--                                    fill="none"-->
<!--                                    viewBox="0 0 24 24"-->
<!--                                    stroke-width="1.5"-->
<!--                                    class="w-7 h-7 stroke-red-500"-->
<!--                                >-->
<!--                                    <path-->
<!--                                        stroke-linecap="round"-->
<!--                                        stroke-linejoin="round"-->
<!--                                        d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 002.288-4.042 1.087 1.087 0 00-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 01-.98-.314l-.295-.295a1.125 1.125 0 010-1.591l.13-.132a1.125 1.125 0 011.3-.21l.603.302a.809.809 0 001.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 001.528-1.732l.146-.292M6.115 5.19A9 9 0 1017.18 4.64M6.115 5.19A8.965 8.965 0 0112 3c1.929 0 3.716.607 5.18 1.64"-->
<!--                                    />-->
<!--                                </svg>-->
<!--                            </div>-->

<!--                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Vibrant Ecosystem</h2>-->

<!--                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">-->
<!--                                Laravel's robust library of first-party tools and libraries, such as-->
<!--                                <a-->
<!--                                    href="https://forge.laravel.com"-->
<!--                                    class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"-->
<!--                                    >Forge</a-->
<!--                                >,-->
<!--                                <a-->
<!--                                    href="https://vapor.laravel.com"-->
<!--                                    class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"-->
<!--                                    >Vapor</a-->
<!--                                >,-->
<!--                                <a-->
<!--                                    href="https://nova.laravel.com"-->
<!--                                    class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"-->
<!--                                    >Nova</a-->
<!--                                >, and-->
<!--                                <a-->
<!--                                    href="https://envoyer.io"-->
<!--                                    class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"-->
<!--                                    >Envoyer</a-->
<!--                                >-->
<!--                                help you take your projects to the next level. Pair them with powerful open source-->
<!--                                libraries like-->
<!--                                <a-->
<!--                                    href="https://laravel.com/docs/billing"-->
<!--                                    class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"-->
<!--                                    >Cashier</a-->
<!--                                >,-->
<!--                                <a-->
<!--                                    href="https://laravel.com/docs/dusk"-->
<!--                                    class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"-->
<!--                                    >Dusk</a-->
<!--                                >,-->
<!--                                <a-->
<!--                                    href="https://laravel.com/docs/broadcasting"-->
<!--                                    class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"-->
<!--                                    >Echo</a-->
<!--                                >,-->
<!--                                <a-->
<!--                                    href="https://laravel.com/docs/horizon"-->
<!--                                    class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"-->
<!--                                    >Horizon</a-->
<!--                                >,-->
<!--                                <a-->
<!--                                    href="https://laravel.com/docs/sanctum"-->
<!--                                    class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"-->
<!--                                    >Sanctum</a-->
<!--                                >,-->
<!--                                <a-->
<!--                                    href="https://laravel.com/docs/telescope"-->
<!--                                    class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"-->
<!--                                    >Telescope</a-->
<!--                                >, and more.-->
<!--                            </p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

<!--            <div class="flex justify-center mt-16 px-6 sm:items-center sm:justify-between">-->
<!--                <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left">-->
<!--                    <div class="flex items-center gap-4">-->
<!--                        <a-->
<!--                            href="https://github.com/sponsors/taylorotwell"-->
<!--                            class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"-->
<!--                        >-->
<!--                            <svg-->
<!--                                xmlns="http://www.w3.org/2000/svg"-->
<!--                                fill="none"-->
<!--                                viewBox="0 0 24 24"-->
<!--                                stroke-width="1.5"-->
<!--                                class="-mt-px mr-1 w-5 h-5 stroke-gray-400 dark:stroke-gray-600 group-hover:stroke-gray-600 dark:group-hover:stroke-gray-400"-->
<!--                            >-->
<!--                                <path-->
<!--                                    stroke-linecap="round"-->
<!--                                    stroke-linejoin="round"-->
<!--                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"-->
<!--                                />-->
<!--                            </svg>-->
<!--                            Sponsor-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->

<!--                <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">-->
<!--                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</template>
