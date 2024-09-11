import { Association } from "./associations-response"

export type TicketsResponse = {
  data: Data
  message: null
  success: boolean
}

export type Data = {
  tickets: Ticket[]
}

export type Ticket = {
  id: number
  code: string
  title: string
  content: Content | null
  association: Association
  status: Status
  can_apply_appeal: boolean
  category: null | string
  created_at: Date
}

export type Content = {
  id: number
  content: string
  sender: Sender
}

export type Sender = {
  id: number
  name: string
  avatar: string
  role: null
}

export type Status = {
  id: number
  name: string
  color_type: string
  text: string
  bg_color: string
}
