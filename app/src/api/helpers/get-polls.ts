import { PollsResponse } from "@/types/polls-response"

import AmlackApi from ".."

export const getPolls = async ({ association_id }: { association_id: string }) => {
  let url = `/polls`
  const response = await AmlackApi.get<PollsResponse>(url, {
    params: {
      association_id,
    },
  })

  return response.data
}
