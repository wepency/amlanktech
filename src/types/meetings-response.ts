export type MeetingsResponse = {
  data: Data
  message: null
  success: boolean
}

export type Data = {
  meetings: Meeting[]
  from: number
  to: number
  total: number
  per_page: number
  current_page: number
  last_page: number
  next_page_url: null
  previous_page_url: null
}

export type Meeting = {
  id: number
  title: string
  date: Date
  start_time: Date
  meeting_id: string
  passcode: string
  created_at: string
  current_users: number
  is_started: boolean
  description?: string
  min_users: null | number
}
