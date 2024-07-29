export type AssociationsResponse = {
  data: Data
  message: null
  success: boolean
}

export type Data = {
  associations: Association[]
  from: number
  to: number
  total: number
  per_page: number
  current_page: number
  last_page: number
  next_page_url: null
  previous_page_url: null
}

export type Association = {
  id: number
  name: string
  map_link: string
  registration_number: string
  city: City
  address: string
  feeType: {
    label: string
    key: null
    id: number
  } | null
}

export type City = {
  id: number
  name: string
}
