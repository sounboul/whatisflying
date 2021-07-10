import spdxLicenseList from 'spdx-license-list'

class SpdxLicense {
  static getLicenseName (identifier) {
    return spdxLicenseList[identifier]?.name
  }

  static getLicenseUrl (identifier) {
    return spdxLicenseList[identifier]?.url
  }
}

export default SpdxLicense
