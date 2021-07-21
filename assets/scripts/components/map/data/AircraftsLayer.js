import i18n from '@scripts/i18n'
import Math from '@scripts/mathjs'
import { AircraftState } from '@scripts/services/opensky-network'
import { CancelToken } from 'axios'
import { DateTime } from 'luxon'
import * as OpenLayers from 'ol'
import * as Condition from 'ol/events/condition'
import * as Geometry from 'ol/geom'
import * as Interaction from 'ol/interaction'
import * as Layer from 'ol/layer'
import * as LoadingStrategy from 'ol/loadingstrategy'
import * as Projection from 'ol/proj'
import * as Source from 'ol/source'
import * as Style from 'ol/style'
import { onUnmounted, ref, watch } from 'vue'
import { useGetters } from 'vuex-composition-helpers'

export const useAircraftsLayer = (map, props, filters, selection, aircraftCache) => {
  const cancelToken = ref(null)
  const currentAircraftsLayer = ref(null)
  const currentAircraftsSelect = ref(null)
  const refreshInterval = ref(null)
  const refreshTimeout = ref(null)

  const { showAircrafts } = useGetters(['showAircrafts'])

  const applyAircraftFilters = () => {
    currentAircraftsLayer.value?.getSource().forEachFeature(feature => {
      const properties = feature.getProperties()
      feature.setProperties({
        hidden: isAircraftHidden(properties)
      })
    })
  }

  const generateAircraftIcon = (properties, zoom) => {
    const { aircraftType, description, hidden, onGround, selected, squawk, track } = properties

    let icon = require('@images/aircraft/L.svg')
    let color = '#fabd00'

    if (selected) {
      color = '#0085ad'
    } else if (squawk === '7700') {
      color = '#e4002b'
    } else if (squawk === '7600') {
      color = '#ff7700'
    } else if (squawk === '7500') {
      color = '#25272a'
    } else if (hidden) {
      color = '#606468'
    } else if (onGround) {
      color = '#abaeb1'
    }

    if (description && aircraftType) {
      if (aircraftType === 'B721') {
        icon = require('@images/aircraft/B721.svg')
      } else if (aircraftType === 'B722') {
        icon = require('@images/aircraft/B722.svg')
      } else if (aircraftType === 'B733') {
        icon = require('@images/aircraft/B733.svg')
      } else if (aircraftType === 'B734') {
        icon = require('@images/aircraft/B734.svg')
      } else if (aircraftType === 'B737') {
        icon = require('@images/aircraft/B737.svg')
      } else if (aircraftType === 'B738') {
        icon = require('@images/aircraft/B738.svg')
      } else if (aircraftType === 'B741') {
        icon = require('@images/aircraft/B741.svg')
      } else if (aircraftType === 'B744') {
        icon = require('@images/aircraft/B744.svg')
      } else if (aircraftType === 'B748') {
        icon = require('@images/aircraft/B748.svg')
      } else if (aircraftType === 'B74S') {
        icon = require('@images/aircraft/B74S.svg')
      } else if (aircraftType === 'B752') {
        icon = require('@images/aircraft/B752.svg')
      } else if (aircraftType === 'B753') {
        icon = require('@images/aircraft/B753.svg')
      } else if (aircraftType === 'B762') {
        icon = require('@images/aircraft/B762.svg')
      } else if (aircraftType === 'B763') {
        icon = require('@images/aircraft/B763.svg')
      } else if (aircraftType === 'B764') {
        icon = require('@images/aircraft/B764.svg')
      } else if (aircraftType === 'B772') {
        icon = require('@images/aircraft/B772.svg')
      } else if (aircraftType === 'B773') {
        icon = require('@images/aircraft/B773.svg')
      } else if (aircraftType === 'B77L') {
        icon = require('@images/aircraft/B77L.svg')
      } else if (aircraftType === 'B77W') {
        icon = require('@images/aircraft/B77W.svg')
      } else if (aircraftType === 'B788') {
        icon = require('@images/aircraft/B788.svg')
      } else if (aircraftType === 'B789') {
        icon = require('@images/aircraft/B789.svg')
      } else if (aircraftType === 'C152') {
        icon = require('@images/aircraft/C152.svg')
      } else if (aircraftType === 'C172') {
        icon = require('@images/aircraft/C172.svg')
      } else if (aircraftType === 'C182') {
        icon = require('@images/aircraft/C182.svg')
      } else if (description.startsWith('H')) {
        icon = require('@images/aircraft/H.svg')
      } else if (description.match(/^L1[PT]$/)) {
        icon = require('@images/aircraft/L1P-T.svg')
      } else if (description.match(/^L2[PT]$/)) {
        icon = require('@images/aircraft/L2P-T.svg')
      } else if (description === 'L1J') {
        icon = require('@images/aircraft/L1J.svg')
      } else if (description === 'L3J') {
        icon = require('@images/aircraft/L3J.svg')
      } else if (description === 'L4J') {
        icon = require('@images/aircraft/L4J.svg')
      }
    }

    return new Style.Icon({
      anchor: [0.5, 0.5],
      anchorXUnits: 'fraction',
      anchorYUnits: 'fraction',
      color,
      opacity: (hidden && !selected) ? 0.25 : 1.0,
      rotation: (track * Math.pi) / 180.0,
      scale: 0.175 * Math.log(zoom),
      src: icon
    })
  }

  const generateAircraftLabel = properties => {
    const { aircraftType, altitude, callsign = '-', groundSpeed, onGround, verticalSpeed } = properties
    const text = [callsign.trim() || i18n.global.t('no_callsign')]

    if (!onGround) {
      text.push(
        `${Math.round(Math.unit(altitude, 'm').toNumber('ft'))} ft`,
        `${Math.round(Math.unit(groundSpeed, 'm/s').toNumber('kt'))} kt`,
        `${Math.round(Math.unit(verticalSpeed, 'm/s').toNumber('fpm'))} fpm`
      )
    }

    if (aircraftType) {
      text.push(aircraftType)
    }

    return new Style.Text({
      font: 'normal 500 11.5px "Fira Sans", sans-serif',
      offsetX: 0,
      offsetY: 25,
      padding: [4, 2, 2, 4],
      text: text.join('\n'),
      textAlign: 'center',
      textBaseline: 'top',
      backgroundFill: new Style.Fill({
        color: 'rgba(46, 50, 55, 0.65)'
      }),
      fill: new Style.Fill({
        color: '#f6f8fa'
      })
    })
  }

  const generateAircraftStyle = feature => {
    const zoom = map.value.getView().getZoom()
    const properties = feature.getProperties()
    const { altitude, hidden } = properties
    const zIndex = Math.max(Math.round(Math.unit(altitude, 'm').toNumber('ft')), 0)

    const style = new Style.Style({
      image: generateAircraftIcon(properties, zoom),
      zIndex
    })

    if (zoom >= 9 && !hidden) {
      style.setText(generateAircraftLabel(properties))
    }

    return style
  }

  const getAircraftCorrectedPosition = properties => {
    const { groundSpeed, lastPositionUpdate, latitude, longitude, track } = properties
    const angularDistance = (groundSpeed * (DateTime.utc().toSeconds() - lastPositionUpdate)) / 6371009
    const correctedLatitude = Math.asin((Math.sin(Math.unit(latitude, 'deg')) *
      Math.cos(angularDistance)) + (Math.cos(Math.unit(latitude, 'deg')) *
      Math.sin(angularDistance) * Math.cos(Math.unit(track, 'deg'))))
    const correctedLongitude = Math.unit(longitude, 'deg').toNumber('rad') +
      (Math.atan2((Math.sin(Math.unit(track, 'deg')) * Math.sin(angularDistance) *
        Math.cos(Math.unit(latitude, 'deg'))), Math.cos((angularDistance) -
        (Math.sin(Math.unit(latitude, 'deg')) * Math.sin(latitude)))))

    return [
      Math.unit(correctedLongitude, 'rad').toNumber('deg'),
      Math.unit(correctedLatitude, 'rad').toNumber('deg')
    ]
  }

  const isAircraftHidden = properties => {
    const { aircraftType, altitude, callsign, squawk } = properties
    const {
      aircraftType: aircraftTypeFilter = [],
      callsign: callsignFilter,
      squawk: squawkFilter,
      maximumAltitude: maximumAltitudeFilter,
      minimumAltitude: minimumAltitudeFilter
    } = filters.value

    return (
      (aircraftTypeFilter.length && (!aircraftType || !aircraftTypeFilter.includes(aircraftType))) ||
      (callsignFilter && !callsign.startsWith(callsignFilter)) ||
      (squawkFilter && (!squawk || squawk !== squawkFilter)) ||
      (maximumAltitudeFilter && Math.unit(altitude, 'm').toNumber('ft') > Number(maximumAltitudeFilter)) ||
      (minimumAltitudeFilter && Math.unit(altitude, 'm').toNumber('ft') < Number(minimumAltitudeFilter))
    )
  }

  const setupAircraftsLayer = () => {
    const aircraftsSource = new Source.Vector({
      strategy: LoadingStrategy.bbox,
      loader: extent => {
        cancelToken.value?.cancel('Concurrent request')
        cancelToken.value = CancelToken.source()

        clearTimeout(refreshTimeout.value)
        refreshTimeout.value = window.setTimeout(setupAircraftsLayer, 5000)

        const boundingBox = Projection.transformExtent(extent, 'EPSG:3857', 'EPSG:4326')
        AircraftState.getAircraftStates({
          cancelToken: cancelToken.value.token,
          params: {
            lamin: boundingBox[1],
            lamax: boundingBox[3],
            lomin: boundingBox[0],
            lomax: boundingBox[2]
          }
        }).then(aircraftStates => {
          const features = []
          aircraftStates.forEach(aircraftState => {
            const { icao24bitAddress } = aircraftState
            const aircraftCorrectedPosition = getAircraftCorrectedPosition(aircraftState)
            const coordinates = Projection.transform(aircraftCorrectedPosition, 'EPSG:4326', 'EPSG:3857')

            const feature = new OpenLayers.Feature({
              geometry: new Geometry.Point(coordinates)
            })

            feature.setId(icao24bitAddress)
            feature.setProperties(aircraftState)
            feature.setStyle(feature => generateAircraftStyle(feature))

            if (icao24bitAddress in aircraftCache.value) {
              const { aircraftType, description } = aircraftCache.value[icao24bitAddress]
              feature.setProperties({ aircraftType, description })
            }

            if (icao24bitAddress === selection.value?.aircraft) {
              feature.setProperties({ selected: true })
              aircraftsSelect.getFeatures().push(feature)
            }

            const properties = feature.getProperties()
            feature.setProperties({
              hidden: isAircraftHidden(properties)
            })

            features.push(feature)
          })

          aircraftsSource.addFeatures(features)
        })

        refreshInterval.value = window.setInterval(() => {
          const zoom = map.value.getView().getZoom()
          aircraftsSource.forEachFeatureInExtent(extent, feature => {
            const properties = feature.getProperties()
            const { onGround, selected } = properties
            if (!onGround && (zoom >= 9 || selected)) {
              const aircraftCorrectedPosition = getAircraftCorrectedPosition(properties)
              const coordinates = Projection.transform(aircraftCorrectedPosition, 'EPSG:4326', 'EPSG:3857')
              feature.getGeometry().setCoordinates(coordinates)
            }
          })
        }, 1000)
      }
    })

    const aircraftsSelect = new Interaction.Select({
      condition: Condition.singleClick,
      features: new OpenLayers.Collection(),
      layers: layer => layer.ol_uid === aircraftsLayer.ol_uid,
      style: feature => {
        const zoom = map.value.getView().getZoom()
        const properties = feature.getProperties()

        return new Style.Style({
          zIndex: 100000,
          image: generateAircraftIcon(properties, zoom),
          text: generateAircraftLabel(properties)
        })
      }
    })

    const aircraftsLayer = new Layer.Vector({
      extent: Projection.transformExtent([-180, -90, 180, 90], 'EPSG:4326', 'EPSG:3857'),
      source: aircraftsSource,
      visible: props.forceShowAircrafts || showAircrafts.value,
      zIndex: 200
    })

    aircraftsSelect.on('select', event => {
      if (event.deselected.length) {
        const feature = event.deselected[0]
        feature.setProperties({ selected: false })
        delete selection.value.aircraft
        delete selection.value.flight
      }

      if (event.selected.length) {
        const feature = event.selected[0]
        feature.setProperties({ selected: true })
        const { callsign, icao24bitAddress } = feature.getProperties()
        selection.value.aircraft = icao24bitAddress
        selection.value.flight = callsign
      }
    })

    aircraftsSource.once('change', () => {
      map.value.removeLayer(currentAircraftsLayer.value)
      map.value.removeInteraction(currentAircraftsSelect.value)

      currentAircraftsLayer.value = aircraftsLayer
      currentAircraftsSelect.value = aircraftsSelect
    })

    map.value.addLayer(aircraftsLayer)
    map.value.addInteraction(aircraftsSelect)
  }

  watch(filters, () => applyAircraftFilters(), { deep: true })

  watch(showAircrafts, showAircrafts => {
    currentAircraftsLayer?.value.setVisible(showAircrafts)
  })

  watch(() => selection.value.aircraft, aircraft => {
    if (!aircraft) {
      currentAircraftsSelect.value?.getFeatures().forEach(feature => {
        currentAircraftsSelect.value?.getFeatures().remove(feature)
        feature.setProperties({ selected: false })
      })
    }
  })

  onUnmounted(() => {
    cancelToken.value?.cancel('Component unmounted')
    clearInterval(refreshInterval.value)
    clearTimeout(refreshTimeout.value)
  })

  return { setupAircraftsLayer }
}
