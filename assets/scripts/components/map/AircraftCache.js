import AircraftCacheWorker from '@scripts/worker/aircraft-cache-worker'
import Axios, { CancelToken } from 'axios'
import Papa from 'papaparse'
import { onUnmounted, ref } from 'vue'

const DATABASE_VERSION = 1

export const useAircraftCache = aircraftCache => {
  const cancelToken = ref(null)

  const setupAircraftCache = () => {
    const databaseOpen = window.indexedDB.open('whatisflying', DATABASE_VERSION)
    databaseOpen.addEventListener('upgradeneeded', event => {
      const database = event.target.result
      if (event.oldVersion < 1) {
        const store = database.createObjectStore('aircrafts', { keyPath: 'icao24bitAddress' })
        store.createIndex('by_icao24bitAddress', 'icao24bitAddress', { unique: true })
      }
    })

    databaseOpen.addEventListener('success', event => {
      const { result: database } = event.target
      if (database.objectStoreNames.contains('aircrafts')) {
        const transaction = database.transaction('aircrafts', 'readonly')
        const store = transaction.objectStore('aircrafts')
        const request = store.getAll()
        request.addEventListener('success', event => {
          const aircrafts = event.target.result
          aircrafts.forEach(aircraft => {
            const { aircraftType, description, icao24bitAddress } = aircraft
            aircraftCache.value[icao24bitAddress] = { aircraftType, description }
          })
        })
      }

      database.close()
    })

    cancelToken.value = CancelToken.source()
    Axios.get('/cache/aircraft.csv', {
      cancelToken: cancelToken.value.token,
      headers: {
        accept: 'text/csv'
      }
    }).then(response => {
      const aircrafts = []
      Papa.parse(response.data).data.forEach(row => {
        const { 0: icao24bitAddress, 1: aircraftType, 2: description } = row
        aircrafts.push({ icao24bitAddress, aircraftType, description })
        aircraftCache.value[icao24bitAddress] = { aircraftType, description }
      })

      const aircraftCacheWorker = new AircraftCacheWorker()
      aircraftCacheWorker.postMessage({
        aircrafts,
        databaseVersion: DATABASE_VERSION
      })
    })
  }

  onUnmounted(() => cancelToken.value?.cancel('Component unmounted'))

  return { setupAircraftCache }
}
