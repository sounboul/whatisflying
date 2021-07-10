import Client from '@scripts/services/opensky-network/client'

class AircraftState {
  static getAircraftState (icao24bitAddress, params) {
    return new Promise((resolve, reject) => {
      Client.get('/states/all', {
        ...params,
        params: {
          icao24: icao24bitAddress
        }
      }).then(response => {
        resolve(this.parseAircraftState(response.data.states[0]))
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getAircraftStates (params) {
    return new Promise((resolve, reject) => {
      Client.get('/states/all', params).then(response => {
        let aircraftStates = response.data.states || []
        aircraftStates = aircraftStates.map(aircraftState => this.parseAircraftState(aircraftState))
        resolve(aircraftStates)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static parseAircraftState (aircraftState) {
    return {
      altitude: aircraftState[7] || 0,
      callsign: String(aircraftState[1]).trim(),
      elevation: aircraftState[13] || 0,
      groundSpeed: aircraftState[9] || 0,
      icao24bitAddress: aircraftState[0],
      lastContact: aircraftState[4],
      lastPositionUpdate: aircraftState[3],
      latitude: aircraftState[6] || 0,
      longitude: aircraftState[5] || 0,
      onGround: aircraftState[8],
      source: aircraftState[16],
      squawk: aircraftState[14],
      track: aircraftState[10] || 0,
      verticalSpeed: aircraftState[11] || 0
    }
  }
}

export default AircraftState
