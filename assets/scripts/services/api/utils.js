export function getViolations (data) {
  const violations = {}
  data.violations.forEach(violation => {
    const { code, message, propertyPath } = violation
    violations[propertyPath] = [
      ...violations[propertyPath] || [],
      { code, message }
    ]
  })

  return violations
}
