import { PlansResponse } from "@/types/plans-response"

import AmlackApi from ".."

export const getPlan = async (planId: string) => {
  return AmlackApi.get<{
    data: {
      plan: PlansResponse
    }
  }>(`/plans/${planId}`)
}
