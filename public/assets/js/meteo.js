const weatherIcons = { // objet liste d'icon
    "Rain": "wi wi-day-rain",
    "Clouds": "wi wi-day-cloudy",
    "Clear": "wi wi-day-sunny",
    "Snow": "wi wi-day-snow",
    "Mist": "wi wi-day-fog",
    "Drizzle": "wi wi-day-sleet",
}

const APIKEY = `2e0e5ede742861192d75ef2771bd649e`;
let apiCall = function (city) {
    let url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${APIKEY}&lang=fr&units=metric&lang=fr`;

    fetch(url)
        .then((response) =>
            response.json().then((data) => {
                console.log(data);
                const name = data.name;
                const temperature = data.main.temp;
                const conditions = data.weather[0].main;
                const description = data.weather[0].description;
                const vent = data.wind.speed;
                const humidite = data.main.humidity;
                const pression = data.main.pressure;

                function cap(str) { // capitalise la première lettre du texte
                    return str[0].toUpperCase() + str.slice(1); //et on rajoute le reste du tableau à partir de la 2ème lettre
                }

                function Km() { // fonction de conversion noeud en Km/hz
                    var x = vent;
                    var y = 1.852;
                    var z = x * y;
                    return z
                }

                document.querySelector('#city').textContent = name; // ville
                document.querySelector('#temperature').textContent = Math.round(temperature); // arrondi le chiffre de température
                document.querySelector('#conditions').textContent = cap(description); // capitalise la première lettre
                document.querySelector('#vent').textContent = Math.round(Km(vent));
                document.querySelector('#humidite').textContent = humidite;
                document.querySelector('#pression').textContent = pression;
                document.querySelector('i.wi').className = weatherIcons[conditions];
                document.querySelector('#cont').className = conditions.toLowerCase();
            })
        )
        .catch((err) => console.log('Erreur : ' + err));
};
document.querySelector('form').addEventListener('submit', function (e) {
    e.preventDefault();
    let ville = document.querySelector('#inputCity').value;

    apiCall(ville);
});

apiCall('Courchevel');