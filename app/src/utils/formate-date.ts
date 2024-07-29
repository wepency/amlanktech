export function formatToArabicDate(date: Date): string {
  date = new Date(date)
  // Array of Arabic month names
  const arabicMonths = [
    "يناير",
    "فبراير",
    "مارس",
    "أبريل",
    "مايو",
    "يونيو",
    "يوليو",
    "أغسطس",
    "سبتمبر",
    "أكتوبر",
    "نوفمبر",
    "ديسمبر",
  ]

  // Extracting the day, month, and year from the date
  const day = date.getDate()
  const monthIndex = date.getMonth()
  const year = date.getFullYear()

  // Formatting the date in Arabic format
  const arabicDate = `${day} ${arabicMonths[monthIndex]}, ${year}`

  return arabicDate
}

export function formatTimeTo12Hour(date: Date): string {
  date = new Date(date)
  let hours = date.getHours()
  const minutes = date.getMinutes()
  const ampm = hours >= 12 ? "م" : "ص"

  hours = hours % 12
  hours = hours ? hours : 12 // the hour '0' should be '12'
  const minutesStr = minutes < 10 ? "0" + minutes : minutes.toString()

  return `${hours}:${minutesStr} ${ampm}`
}
