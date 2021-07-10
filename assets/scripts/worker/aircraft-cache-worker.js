self.addEventListener('message', message => {
  const { aircrafts, databaseVersion } = message.data
  const databaseOpen = self.indexedDB.open('whatisflying', databaseVersion)
  databaseOpen.addEventListener('upgradeneeded', event => {
    event.target.transaction.abort()
  })

  databaseOpen.addEventListener('success', event => {
    const { result: database } = event.target
    if (database.objectStoreNames.contains('aircrafts')) {
      const transaction = database.transaction('aircrafts', 'readwrite')
      const store = transaction.objectStore('aircrafts')
      aircrafts.forEach(aircraft => {
        const { aircraftType, description, icao24bitAddress } = aircraft
        const request = store.count(aircraft.icao24bitAddress)
        request.addEventListener('success', event => {
          const { result: count } = event.target
          if (!count) {
            store.add({ aircraftType, description, icao24bitAddress })
          }
        })
      })
    }
    database.close()
  })
})
