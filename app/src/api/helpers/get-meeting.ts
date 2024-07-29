import { MeetingResponse } from "@/types/meeting-response"

import AmlackApi from ".."

export const getMeeting = async ({ meetingID }: { meetingID: string }) => {
  let url = `/meetings/${meetingID}`
  const response = await AmlackApi.get<MeetingResponse>(url)

  return response.data
}
