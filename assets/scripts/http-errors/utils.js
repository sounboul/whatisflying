import * as HttpError from '@scripts/http-errors/errors'

export function getErrorFromResponse (response) {
  let error = new HttpError.HttpError()

  if (response.status === 400) {
    error = new HttpError.BadRequest()
  } else if (response.status === 401) {
    error = new HttpError.Unauthorized()
  } else if (response.status === 403) {
    error = new HttpError.Forbidden()
  } else if (response.status === 404) {
    error = new HttpError.NotFound()
  } else if (response.status === 405) {
    error = new HttpError.MethodNotAllowed()
  } else if (response.status === 406) {
    error = new HttpError.NotAcceptable()
  } else if (response.status === 407) {
    error = new HttpError.ProxyAuthenticationRequired()
  } else if (response.status === 408) {
    error = new HttpError.RequestTimeout()
  } else if (response.status === 409) {
    error = new HttpError.Conflict()
  } else if (response.status === 410) {
    error = new HttpError.Gone()
  } else if (response.status === 411) {
    error = new HttpError.LengthRequired()
  } else if (response.status === 412) {
    error = new HttpError.PreconditionFailed()
  } else if (response.status === 413) {
    error = new HttpError.PayloadTooLarge()
  } else if (response.status === 414) {
    error = new HttpError.UriTooLong()
  } else if (response.status === 415) {
    error = new HttpError.UnsupportedMediaType()
  } else if (response.status === 416) {
    error = new HttpError.RangeNotSatisfiable()
  } else if (response.status === 417) {
    error = new HttpError.ExpectationFailed()
  } else if (response.status === 421) {
    error = new HttpError.MisdirectedRequest()
  } else if (response.status === 422) {
    error = new HttpError.UnprocessableEntity()
  } else if (response.status === 423) {
    error = new HttpError.Locked()
  } else if (response.status === 424) {
    error = new HttpError.FailedDependency()
  } else if (response.status === 425) {
    error = new HttpError.TooEarly()
  } else if (response.status === 426) {
    error = new HttpError.UpgradeRequired()
  } else if (response.status === 428) {
    error = new HttpError.PreconditionRequired()
  } else if (response.status === 429) {
    error = new HttpError.TooManyRequests()
  } else if (response.status === 431) {
    error = new HttpError.RequestHeaderFieldsTooLarge()
  } else if (response.status === 451) {
    error = new HttpError.UnavailableForLegalReasons()
  } else if (response.status === 500) {
    error = new HttpError.InternalServerError()
  } else if (response.status === 501) {
    error = new HttpError.NotImplemented()
  } else if (response.status === 502) {
    error = new HttpError.BadGateway()
  } else if (response.status === 503) {
    error = new HttpError.ServiceUnavailable()
  } else if (response.status === 504) {
    error = new HttpError.GatewayTimeout()
  } else if (response.status === 505) {
    error = new HttpError.HttpVersionNotSupported()
  } else if (response.status === 506) {
    error = new HttpError.VariantAlsoNegotiates()
  } else if (response.status === 507) {
    error = new HttpError.InsufficientStorage()
  } else if (response.status === 508) {
    error = new HttpError.LoopDetected()
  } else if (response.status === 510) {
    error = new HttpError.NotExtended()
  } else if (response.status === 511) {
    error = new HttpError.NetworkAuthenticationRequired()
  } else if (response.status >= 400 && response.status <= 499) {
    error = new HttpError.ClientError()
  } else if (response.status >= 500 && response.status <= 599) {
    error = new HttpError.ServerError()
  }

  error.response = response

  return error
}
