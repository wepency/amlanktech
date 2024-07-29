import { MeetingsResponse } from "@/types/meetings-response"

import AmlackApi from ".."

export const getMeetings = async ({
  pageParam,
  association_id,
}: {
  pageParam: string
  association_id: string
}) => {
  let url = `/meetings?page=${pageParam}`
  const response = await AmlackApi.get<MeetingsResponse>(url, {
    params: {
      association_id,
    },
  })

  return response.data
}
