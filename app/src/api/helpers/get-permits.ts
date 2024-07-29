import { PermitsResponse } from "@/types/permits-response"

import AmlackApi from ".."

export const getPermits = async ({ association_id }: { association_id: string }) => {
  let url = `/permits`
  const response = await AmlackApi.get<PermitsResponse>(url, {
    params: {
      association_id,
    },
  })

  return response.data
}
