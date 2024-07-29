export type SubscriptionsResponse = {
  data: Data
  message: null
  success: boolean
}

export type Data = {
  subscriptions: Subscription[]
}

export type Subscription = {
  id: number
  unit: Unit
  association: CityClass
  due_date: Date
  unit_price: null | string
  payment_term: null | string
  total: string
  payment_period: number
  payment_period_text: string
  last_payment_date: string
  next_payment_date: string
  status: Status
}

export type CityClass = {
  id: number | null
  name: null | string
}

export type Status = {
  id: number
  text: string
  name: string
  bg_color?: string
  color_type?: string
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
  association: UnitAssociation
  status: Status
  created_at: Date
  updated_at: Date
  created_at_formatted: string
  updated_at_formatted: string
}

export type UnitAssociation = {
  id: number
  name: string
  map_link: string
  registration_number: string
  city: CityClass
  address: string
  feeType: FeeType
}

export type FeeType = {
  id: number
  label: string
  key: null
}
