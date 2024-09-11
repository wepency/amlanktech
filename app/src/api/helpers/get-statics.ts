import { StaticsResponse } from "@/types/statics-response"

import AmlackApi from ".."

export const getStatics = async () => {
  const response = await AmlackApi.get<StaticsResponse>("/statics")
  return response.data.data
}
