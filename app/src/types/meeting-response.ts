export type MeetingResponse = {
  data: Data
  message: null
  success: boolean
}

export type Data = {
  meeting: Meeting
}

export type Meeting = {
  id: number
  title: string
  date: Date
  description: string
  start_time: Date
  meeting_id: string
  passcode: string
  created_at: string
  min_users: null
  current_users: number
  is_started: boolean
}
