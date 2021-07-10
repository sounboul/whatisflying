<template>

  <abbr v-if="navaidType === 'DME'" data-bs-toggle="tooltip"
        :title="$t('distance_measuring_equipment')">DME</abbr>
  <abbr v-else-if="navaidType === 'DME-ILS'" data-bs-toggle="tooltip"
        :title="$t('distance_measuring_equipment_associated_with_an_instrument_landing_system')">DME-ILS</abbr>
  <abbr v-else-if="navaidType === 'DME-NDB'" data-bs-toggle="tooltip"
        :title="$t('distance_measuring_equipment_associated_with_a_non_directional_beacon')">DME-NDB</abbr>
  <abbr v-else-if="navaidType === 'GS'" data-bs-toggle="tooltip"
        :title="$t('glide_slope')">G/S</abbr>
  <abbr v-else-if="navaidType === 'IGS'" data-bs-toggle="tooltip"
        :title="$t('instrument_guidance_system')">IGS</abbr>
  <abbr v-else-if="navaidType === 'ILS-I'" data-bs-toggle="tooltip"
        :title="$t('instrument_landing_system_category_1')">ILS cat. I</abbr>
  <abbr v-else-if="navaidType === 'ILS-II'" data-bs-toggle="tooltip"
        :title="$t('instrument_landing_system_category_2')">ILS cat. II</abbr>
  <abbr v-else-if="navaidType === 'ILS-III'" data-bs-toggle="tooltip"
        :title="$t('instrument_landing_system_category_3')">ILS cat. III</abbr>
  <abbr v-else-if="navaidType === 'IM'" data-bs-toggle="tooltip"
        :title="$t('inner_marker')">IM</abbr>
  <abbr v-else-if="navaidType === 'LDA'" data-bs-toggle="tooltip"
        :title="$t('localizer_type_directional_aid')">LDA</abbr>
  <abbr v-else-if="navaidType === 'LOC'" data-bs-toggle="tooltip"
        :title="$t('localizer')">LOC</abbr>
  <abbr v-else-if="navaidType === 'MM'" data-bs-toggle="tooltip"
        :title="$t('middle_marker')">MM</abbr>
  <abbr v-else-if="navaidType === 'NDB'" data-bs-toggle="tooltip"
        :title="$t('non_directional_beacon')">NDB</abbr>
  <abbr v-else-if="navaidType === 'OM'" data-bs-toggle="tooltip"
        :title="$t('outer_marker')">OM</abbr>
  <abbr v-else-if="navaidType === 'SDF'" data-bs-toggle="tooltip"
        :title="$t('simplified_directional_facility')">SDF</abbr>
  <abbr v-else-if="navaidType === 'TACAN'" data-bs-toggle="tooltip"
        :title="$t('tactical_air_navigation_system')">TACAN</abbr>
  <abbr v-else-if="navaidType === 'VOR'" data-bs-toggle="tooltip"
        :title="t('vhf_omnidirectional_range')">VOR</abbr>
  <abbr v-else-if="navaidType === 'VOR-DME'" data-bs-toggle="tooltip"
        :title="$t('vhf_omnidirectional_range_distance_measuring_equipment')">VOR-DME</abbr>
  <abbr v-else-if="navaidType === 'VORTAC'" data-bs-toggle="tooltip"
        :title="$t('vhf_omnidirectional_range_tactical_air_navigation_system')">VORTAC</abbr>

</template>

<script>
export default {
  name: 'NavaidType',
  props: {
    navaidType: String
  }
}
</script>
