export type UnitsListResponse = {
  data: Data
  message: null
  success: boolean
}

export type Data = {
  units: Unit[]
}

export type Unit = {
  id: number
  area: null
  unit_no: string
  association_id: number
  fee_type_amount: string
  fee_type_total: string
  ownership_type: string
  ownership_ratio: null
  address: string
  water_meter_serial: string
  electricity_meter_serial: string
  created_time: string
  association: Association
  status: Status
  created_at: Date
  updated_at: Date
  created_at_formatted: string
  updated_at_formatted: string
}

export type Association = {
  id: number
  name: string
  map_link: string
  registration_number: string
  city: City
  address: string
  feeType: FeeType
}

export type City = {
  id: null
  name: null
}

export type FeeType = {
  id: number
  label: string
  key: null
}

export type Status = {
  id: number
  name: string
  color_type: string
  text: string
}
