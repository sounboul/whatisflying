export class HttpError extends Error {
  constructor (message, code) {
    super(message)
    this.code = code
  }
}

export class ClientError extends HttpError {
  constructor (response, message, code) {
    super(message, code)
    this.response = response
  }
}

export class BadRequest extends ClientError {
  constructor (response, message = 'Bad Request') {
    super(response, message, 400)
  }
}

export class Unauthorized extends ClientError {
  constructor (response, message = 'Unauthorized') {
    super(response, message, 401)
  }
}

export class Forbidden extends ClientError {
  constructor (response, message = 'Forbidden') {
    super(response, message, 403)
  }
}

export class NotFound extends ClientError {
  constructor (response, message = 'Not Found') {
    super(response, message, 404)
  }
}

export class MethodNotAllowed extends ClientError {
  constructor (response, message = 'Method Not Allowed') {
    super(response, message, 405)
  }
}

export class NotAcceptable extends ClientError {
  constructor (response, message = 'Not Acceptable') {
    super(response, message, 406)
  }
}

export class ProxyAuthenticationRequired extends ClientError {
  constructor (response, message = 'Proxy Authentication Required') {
    super(response, message, 407)
  }
}

export class RequestTimeout extends ClientError {
  constructor (response, message = 'Request Timeout') {
    super(response, message, 408)
  }
}

export class Conflict extends ClientError {
  constructor (response, message = 'Conflict') {
    super(response, message, 409)
  }
}

export class Gone extends ClientError {
  constructor (response, message = 'Gone') {
    super(response, message, 410)
  }
}

export class LengthRequired extends ClientError {
  constructor (response, message = 'Length Required') {
    super(response, message, 411)
  }
}

export class PreconditionFailed extends ClientError {
  constructor (response, message = 'Precondition Failed') {
    super(response, message, 412)
  }
}

export class PayloadTooLarge extends ClientError {
  constructor (response, message = 'Payload Too Large') {
    super(response, message, 413)
  }
}

export class UriTooLong extends ClientError {
  constructor (response, message = 'URI Too Long') {
    super(response, message, 414)
  }
}

export class UnsupportedMediaType extends ClientError {
  constructor (response, message = 'Unsupported Media Type') {
    super(response, message, 415)
  }
}

export class RangeNotSatisfiable extends ClientError {
  constructor (response, message = 'Range Not Satisfiable') {
    super(response, message, 416)
  }
}

export class ExpectationFailed extends ClientError {
  constructor (response, message = 'Expectation Failed') {
    super(response, message, 417)
  }
}

export class MisdirectedRequest extends ClientError {
  constructor (response, message = 'Misdirected Request') {
    super(response, message, 421)
  }
}

export class UnprocessableEntity extends ClientError {
  constructor (response, message = ' Unprocessable Entity') {
    super(response, message, 422)
  }
}

export class Locked extends ClientError {
  constructor (response, message = 'Locked') {
    super(response, message, 423)
  }
}

export class FailedDependency extends ClientError {
  constructor (response, message = 'Failed Dependency') {
    super(response, message, 424)
  }
}

export class TooEarly extends ClientError {
  constructor (response, message = 'Too Early') {
    super(response, message, 425)
  }
}

export class UpgradeRequired extends ClientError {
  constructor (response, message = 'Upgrade Required') {
    super(response, message, 426)
  }
}

export class PreconditionRequired extends ClientError {
  constructor (response, message = 'Precondition Required') {
    super(response, message, 428)
  }
}

export class TooManyRequests extends ClientError {
  constructor (response, message = 'Too Many Requests') {
    super(response, message, 429)
  }
}

export class RequestHeaderFieldsTooLarge extends ClientError {
  constructor (response, message = 'Request Header Fields Too Large') {
    super(response, message, 431)
  }
}

export class UnavailableForLegalReasons extends ClientError {
  constructor (response, message = 'Unavailable For Legal Reasons') {
    super(response, message, 451)
  }
}

export class ServerError extends HttpError {
  constructor (response, message, code) {
    super(message, code)
    this.response = response
  }
}

export class InternalServerError extends ServerError {
  constructor (response, message = 'Internal Server Error') {
    super(response, message, 500)
  }
}

export class NotImplemented extends ServerError {
  constructor (response, message = 'Not Implemented') {
    super(response, message, 501)
  }
}

export class BadGateway extends ServerError {
  constructor (response, message = 'Bad Gateway') {
    super(response, message, 502)
  }
}

export class ServiceUnavailable extends ServerError {
  constructor (response, message = 'Service Unavailable') {
    super(response, message, 503)
  }
}

export class GatewayTimeout extends ServerError {
  constructor (response, message = 'Gateway Timeout') {
    super(response, message, 504)
  }
}

export class HttpVersionNotSupported extends ServerError {
  constructor (response, message = 'HTTP Version Not Supported') {
    super(response, message, 505)
  }
}

export class VariantAlsoNegotiates extends ServerError {
  constructor (response, message = ' Variant Also Negotiates') {
    super(response, message, 506)
  }
}

export class InsufficientStorage extends ServerError {
  constructor (response, message = 'Insufficient Storage') {
    super(response, message, 507)
  }
}

export class LoopDetected extends ServerError {
  constructor (response, message = 'Loop Detected') {
    super(response, message, 508)
  }
}

export class NotExtended extends ServerError {
  constructor (response, message = 'Not Extended') {
    super(response, message, 510)
  }
}

export class NetworkAuthenticationRequired extends ServerError {
  constructor (response, message = 'Network Authentication Required') {
    super(response, message, 511)
  }
}
