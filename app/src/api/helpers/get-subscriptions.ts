import { SubscriptionsResponse } from "@/types/subscriptions-response"

import AmlackApi from ".."

export const getSubscriptions = async ({
  association_id,
}: {
  association_id: string
}) => {
  let url = `/subscriptions`
  const response = await AmlackApi.get<SubscriptionsResponse>(url, {
    params: {
      association_id,
    },
  })

  return response.data
}
