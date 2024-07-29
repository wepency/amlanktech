import { Association } from "./associations-response"

export type TicketResponse = {
  data: Data
  message: null
  success: boolean
}

export type Data = {
  ticket: Ticket
}

export type Ticket = {
  id: number
  code: string
  title: string
  content: Content
  association: Association
  status: Status
  can_apply_appeal: boolean
  created_at: Date
  replies: Reply[]
}

export type Content = {
  id: number
  content: string
  sender: Sender
}

export type Sender = {
  id: number | null
  name: null | string
  avatar: string
  role: null | string
  type?: string
}

export type Reply = {
  id: number
  user: Sender | null
  body: string
  attachments: Attachment[]
  stars: null | number
}

export type Attachment = {
  id: number
  path: string
}

export type Status = {
  id: number
  name: string
  color_type: string
  bg_color: string
  text: string
}
