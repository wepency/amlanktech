import { MeResponse } from "@/types/me-response"

import AmlackApi from ".."

export const getUserData = async () => {
  let url = `/account/me`
  const response = await AmlackApi.get<MeResponse>(url)

  return response.data
}
