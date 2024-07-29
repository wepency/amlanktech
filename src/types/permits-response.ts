import { Association } from "./associations-response"

export type PermitsResponse = {
  data: Data
  message: null
  success: boolean
}

export type Data = {
  permits: Permit[]
}

export type Permit = {
  id: number
  code: null | string
  link: string
  association: Association
  duration: number
  start_date: string
  login_attempts: number
  type: string
  status: Status
  visitors: {
    id: number | null
    name: null | string
  }[]
}

export type Status = {
  name: string
  color_type: string
  text: string
  text_color: string
  bg_color: string
}
