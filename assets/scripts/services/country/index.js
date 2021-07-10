import { continents, countries } from 'countries-list'

class Country {
  static getContinentCodes () {
    return Object.keys(continents)
  }

  static getContinentName (continentCode) {
    return (continentCode in continents) ? continents[continentCode] : null
  }

  static getCountryCodes () {
    return Object.keys(countries)
  }

  static getCountryEmojiFlag (countryCode) {
    return (countryCode in countries) ? countries[countryCode].emoji : null
  }

  static getCountryName (countryCode) {
    return (countryCode in countries) ? countries[countryCode].name : null
  }

  static getCountryNativeName (countryCode) {
    return (countryCode in countries) ? countries[countryCode].native : null
  }
}

export default Country
