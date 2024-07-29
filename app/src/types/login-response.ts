import { Association } from "./associations-response"

export type LoginResponse = {
  data: User[]
  message: null
  success: boolean
}

export type User = {
  id: string
  access_token: string
  user: userData
  associations: Association[]

  token_type: string
  expires_in: null
}

export type userData = {
  id: string
  status: string
  name: string
  email: string
  phonenumber: null | string
  avatar: string
}
