import { all, create } from 'mathjs'

const Math = create(all, {})

Math.createUnit({
  fpm: {
    definition: '0.00508 m/s',
    aliases: ['feet/minute', 'ft/min']
  },
  inHg: {
    definition: '33.863886 hPa',
    aliases: ['in Hg']
  },
  knot: {
    definition: '0.514444 m/s',
    aliases: ['knots', 'kt', 'kts']
  },
  nmi: {
    definition: '1852 m',
    aliases: ['nautical mile']
  }
})

export default Math
