<template>

  <div v-if="showNavaidsLegend && (forceShowNavaids || showNavaids)" class="legend">
    <h4>{{ $t('navaids') }}</h4>
    <div class="row g-2">
      <div class="col-4">
        <img class="me-2" src="@images/navaid/NDB.svg" width="20" height="20" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('non_directional_beacon')">NDB</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/VOR.svg" width="20" height="20" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('vhf_omnidirectional_range')">VOR</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/VOR-DME.svg" width="20" height="20" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('vhf_omnidirectional_range_distance_measuring_equipment')">VOR-DME</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/VORTAC.svg" width="20" height="20" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('vhf_omnidirectional_range_tactical_air_navigation_system')">VORTAC</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/TACAN.svg" width="20" height="20" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('tactical_air_navigation_system')">TACAN</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/DME.svg" width="20" height="20" alt="">
        <abbr class="d-inline-flex" data-bs-toggle="tooltip"
              :title="$t('distance_measuring_equipment')">DME</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/LDA.svg" width="20" height="20" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('localizer_type_directional_aid')">LDA</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/SDF.svg" width="20" height="20" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('simplified_directional_facility')">SDF</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/IGS.svg" width="20" height="20" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('instrument_guidance_system')">IGS</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/LOC.svg" width="20" height="20" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('localizer')">LOC</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/ILS-I.svg" width="20" height="20" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('instrument_landing_system_category_1')">ILS cat. I</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/ILS-II.svg" width="20" height="20" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('instrument_landing_system_category_2')">ILS cat. II</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/ILS-III.svg" width="20" height="20" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('instrument_landing_system_category_3')">ILS cat. III</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/GS.svg" width="20" height="20" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('glide_slope')">G/S</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/OM.svg" width="15" height="15" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('outer_marker')">OM</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/MM.svg" width="15" height="15" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('middle_marker')">MM</abbr>
      </div>
      <div class="col-4">
        <img class="me-2" src="@images/navaid/IM.svg" width="15" height="15" alt="">
        <abbr class="d-inline-block" data-bs-toggle="tooltip"
              :title="$t('inner_marker')">IM</abbr>
      </div>
    </div>
  </div>

</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'NavaidsLegend',
  inject: ['forceShowNavaids'],
  computed: {
    ...mapGetters([
      'showNavaids',
      'showNavaidsLegend'
    ])
  }
}
</script>
