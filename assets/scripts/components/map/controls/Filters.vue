<template>
  <div class="dropend">
    <button class="map-control" type="button" data-bs-toggle="dropdown"
            :title="$t('filters')" aria-haspopup="true" aria-expanded="false">
      <span v-if="activeFilters" class="map-control-badge">{{ activeFilters }}</span>
      <FontAwesomeIcon :icon="['fal', 'filter']" aria-hidden="true"/>
    </button>
    <div class="dropdown-menu map-control-menu ms-2">
      <h4>{{ $t('filters') }}</h4>
      <div class="mt-3">
        <label class="form-label" for="inputAircraftType">{{ $t('label.aircraft_type') }}</label>
        <AircraftTypeSelect id="inputAircraftType" mode="multiple" v-model="filters.value.aircraftType"/>
      </div>
      <div class="mt-3">
        <label class="form-label" for="inputCallsign">{{ $t('label.callsign') }}</label>
        <input class="form-control" id="inputCallsign" type="text" v-model="filters.value.callsign">
      </div>
      <div class="mt-3">
        <label class="form-label" for="inputSquawk">{{ $t('label.squawk') }}</label>
        <input class="form-control" id="inputSquawk" type="text" v-model="filters.value.squawk">
      </div>
      <div class="mt-3">
        <label class="form-label" for="inputMaximumAltitude">{{ $t('label.maximum_altitude') }}</label>
        <input class="form-control" id="inputMaximumAltitude" type="number" v-model="filters.value.maximumAltitude">
      </div>
      <div class="mt-3">
        <label class="form-label" for="inputMinimumAltitude">{{ $t('label.minimum_altitude') }}</label>
        <input class="form-control" id="inputMinimumAltitude" type="number" v-model="filters.value.minimumAltitude">
      </div>
      <div class="mt-3 text-center">
        <button class="btn btn-outline-primary" type="button" @click="resetFilters">
          {{ $t('reset_filters') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import AircraftTypeSelect from '@scripts/components/form/fields/AircraftTypeSelect'
import FontAwesomeIcon from '@scripts/fontawesome'

export default {
  name: 'Filters',
  components: {
    AircraftTypeSelect,
    FontAwesomeIcon
  },
  inject: ['filters'],
  computed: {
    activeFilters () {
      let activeFilters = 0

      Object.values(this.filters.value).forEach(filter => {
        if (filter && (typeof filter !== 'object' || filter.length)) {
          activeFilters += 1
        }
      })

      return activeFilters
    }
  },
  methods: {
    resetFilters () {
      this.filters.value = {}
    }
  }
}
</script>
