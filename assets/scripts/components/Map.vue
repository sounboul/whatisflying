<template>
  <MapLayout>

    <template #map>
      <div class="map" id="map" :key="uuid"></div>
    </template>

    <template #search>
      <Search/>
    </template>

    <template #controls>
      <BaseLayerSelector/>
      <DataLayersSelector/>
      <Filters/>
      <WeatherLayersSelector/>
      <Options/>
      <CenterMap/>
    </template>

    <template #legend>
      <AircraftsLegend/>
      <AirportsLegend/>
      <NavaidsLegend/>
      <AtmosphericPressureLegend/>
      <CloudCoverageLegend/>
      <PrecipitationsLegend/>
      <TemperatureLegend/>
      <WindSpeedLegend/>
    </template>

    <template #overlay>
      <AircraftDetails/>
      <AirportDetails/>
      <FixDetails/>
      <NavaidDetails/>
    </template>

  </MapLayout>
</template>

<script>
import { useAircraftCache } from '@scripts/components/map/AircraftCache'
import { useRoadmapLayer } from '@scripts/components/map/base/RoadmapLayer'
import { useSatelliteLayer } from '@scripts/components/map/base/SatelliteLayer'
import { useAttribution } from '@scripts/components/map/controls/Attribution'
import BaseLayerSelector from '@scripts/components/map/controls/BaseLayerSelector'
import CenterMap from '@scripts/components/map/controls/CenterMap'
import DataLayersSelector from '@scripts/components/map/controls/DataLayersSelector'
import Filters from '@scripts/components/map/controls/Filters'
import Options from '@scripts/components/map/controls/Options'
import { useScaleLine } from '@scripts/components/map/controls/ScaleLine'
import Search from '@scripts/components/map/controls/Search'
import WeatherLayersSelector from '@scripts/components/map/controls/WeatherLayersSelector'
import { useZoom } from '@scripts/components/map/controls/Zoom'
import { useAircraftsLayer } from '@scripts/components/map/data/AircraftsLayer'
import { useAirportsLayer } from '@scripts/components/map/data/AirportsLayer'
import { useFixesLayer } from '@scripts/components/map/data/FixesLayer'
import { useFlightLayer } from '@scripts/components/map/data/FlightLayer'
import { useNavaidsLayer } from '@scripts/components/map/data/NavaidsLayer'
import { useGeolocation } from '@scripts/components/map/Geolocation'
import { useGraticule } from '@scripts/components/map/Graticule'
import AircraftsLegend from '@scripts/components/map/legend/AircraftsLegend'
import AirportsLegend from '@scripts/components/map/legend/AirportsLegend'
import AtmosphericPressureLegend from '@scripts/components/map/legend/AtmosphericPressureLegend'
import CloudCoverageLegend from '@scripts/components/map/legend/CloudCoverageLegend'
import NavaidsLegend from '@scripts/components/map/legend/NavaidsLegend'
import PrecipitationsLegend from '@scripts/components/map/legend/PrecipitationsLegend'
import TemperatureLegend from '@scripts/components/map/legend/TemperatureLegend'
import WindSpeedLegend from '@scripts/components/map/legend/WindSpeedLegend'
import { useMap } from '@scripts/components/map/Map'
import AircraftDetails from '@scripts/components/map/overlay/AircraftDetails'
import AirportDetails from '@scripts/components/map/overlay/AirportDetails'
import FixDetails from '@scripts/components/map/overlay/FixDetails'
import NavaidDetails from '@scripts/components/map/overlay/NavaidDetails'
import { useAtmosphericPressureLayer } from '@scripts/components/map/weather/AtmosphericPressureLayer'
import { useCloudCoverageLayer } from '@scripts/components/map/weather/CloudCoverageLayer'
import { usePrecipitationsLayer } from '@scripts/components/map/weather/PrecipitationsLayer'
import { useTemperatureLayer } from '@scripts/components/map/weather/TemperatureLayer'
import { useWindSpeedLayer } from '@scripts/components/map/weather/WindSpeedLayer'
import MapLayout from '@scripts/layouts/MapLayout'
import * as uuid from 'uuid'
import { provide, ref } from 'vue'

export default {
  name: 'Map',
  components: {
    AircraftDetails,
    AircraftsLegend,
    AirportDetails,
    AirportsLegend,
    AtmosphericPressureLegend,
    BaseLayerSelector,
    CenterMap,
    CloudCoverageLegend,
    DataLayersSelector,
    FixDetails,
    Filters,
    MapLayout,
    NavaidDetails,
    NavaidsLegend,
    Options,
    PrecipitationsLegend,
    Search,
    TemperatureLegend,
    WeatherLayersSelector,
    WindSpeedLegend
  },
  props: {
    featuredAirports: Array,
    featuredNavaids: Array,
    flightNumber: String,
    forceAllowAirportSelection: Boolean,
    forceShowAircrafts: Boolean,
    forceShowAirports: Boolean,
    forceShowFixes: Boolean,
    forceShowNavaids: Boolean,
    latitude: {
      default: 0,
      type: Number
    },
    longitude: {
      default: 0,
      type: Number
    },
    rotation: {
      default: 0,
      type: Number
    },
    zoom: {
      default: 3,
      type: Number
    }
  },
  setup (props, context) {
    const aircraftCache = ref({})
    const filters = ref({})
    const geolocation = ref(null)
    const map = ref(null)
    const selection = ref({})

    provide('filters', filters)
    provide('geolocation', geolocation)
    provide('map', map)
    provide('selection', selection)

    provide('forceShowAircrafts', props.forceShowAircrafts)
    provide('forceShowAirports', props.forceShowAirports)
    provide('forceShowFixes', props.forceShowFixes)
    provide('forceShowNavaids', props.forceShowNavaids)

    return {
      ...useAircraftCache(aircraftCache),
      ...useAircraftsLayer(map, props, filters, selection, aircraftCache),
      ...useAirportsLayer(map, props, selection),
      ...useAtmosphericPressureLayer(map),
      ...useAttribution(map),
      ...useCloudCoverageLayer(map),
      ...useFixesLayer(map, props, selection),
      ...useFlightLayer(map, props),
      ...useGeolocation(map, geolocation),
      ...useGraticule(map),
      ...useMap(map, props, context, '#map'),
      ...useNavaidsLayer(map, props, selection),
      ...usePrecipitationsLayer(map),
      ...useRoadmapLayer(map),
      ...useSatelliteLayer(map),
      ...useScaleLine(map),
      ...useTemperatureLayer(map),
      ...useWindSpeedLayer(map),
      ...useZoom(map)
    }
  },
  data () {
    return {
      uuid: uuid.v4()
    }
  },
  mounted () {
    this.setupMap()

    // Cache
    this.setupAircraftCache()

    // Base layers
    this.setupRoadmapLayer()
    this.setupSatelliteLayer()

    // Data layers
    this.setupAircraftsLayer()
    this.setupAirportsLayer()
    this.setupFixesLayer()
    this.setupFlightLayer()
    this.setupNavaidsLayer()

    // Weather layers
    this.setupAtmosphericPressureLayer()
    this.setupCloudCoverageLayer()
    this.setupPrecipitationsLayer()
    this.setupTemperatureLayer()
    this.setupWindSpeedLayer()

    // Graticule
    this.setupGraticule()

    // Geolocation
    this.setupGeolocation()

    // Controls
    this.setupAttribution()
    this.setupScaleLine()
    this.setupZoom()
  }
}
</script>
