import { Association } from "./associations-response"

export type MeResponse = {
  data: Data
  message: null
  success: boolean
}

export type Data = {
  access_token: string
  user: User
  associations: Association[]
  statics: Statics
  token_type: string
  expires_in: null
}

export type Statics = {
  associations: number
  units: number
  tickets: number
  subscriptions: number
  awaiting_subscriptions: number
}
export type User = {
  id: number
  status: string
  name: string
  email: string
  phonenumber: null | string
  avatar: string
}
