interface AnyObject {
  [key: string]: any
}

export function objectToFormData(obj: AnyObject): FormData {
  const formData = new FormData()

  for (const key in obj) {
    formData.append(key, obj[key])
  }

  return formData
}
