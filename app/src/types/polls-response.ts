export type PollsResponse = {
  data: Data
  message: null
  success: boolean
}

export type Data = {
  polls: Poll[]
}

export type Poll = {
  id: number
  name: string
  votes_count: number
  is_answered: boolean
  selected_option_id: number
  options: Option[]
  created_at: Date
}

export type Option = {
  id: number
  name: string
  votes_count: number
  vote_percent: number
  is_selected: boolean
  votes: Vote[]
}

export type Vote = {
  id: number
  name: string
  avatar: string
  role: null
}
