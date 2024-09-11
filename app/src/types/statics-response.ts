export interface StaticsResponse {
  data: Data
  message: null
  success: boolean
}

export interface Data {
  associations: number
  units: number
  subscriptionsToPay: number
  tickets: number
  subscriptions: number
}
