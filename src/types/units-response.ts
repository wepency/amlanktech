import { Association } from "./associations-response"

export type UnitsResponse = {
  data: Data
  message: null
  success: boolean
}
export type UnitResponse = {
  data: {
    unit: Unit
  }
  message: null
  success: boolean
}

export type Data = {
  active_units: number
  blocked_units: number
  pending_units: number
  units: Unit[]
  from: number
  to: number
  total: number
  per_page: number
  current_page: number
  last_page: number
  next_page_url: null
  previous_page_url: null
}

export type Unit = {
  id: number
  area: null | number
  unit_no: null | string
  association_id: number
  fee_type_amount: number
  fee_type_total: number
  ownership_type: "individual" | "group"
  ownership_ratio: null
  address: string
  water_meter_serial: string
  electricity_meter_serial: string
  created_time: string
  association: Association
  created_at: Date
  updated_at: Date
  status: Status
}

export type Status = {
  id: number
  name: string
  color_type: "warning" | "success" | "danger"
  text: string
}
