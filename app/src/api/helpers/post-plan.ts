import AmlackApi from ".."

export const PostPlan = async (planId: string) => {
  return AmlackApi.post(`/payment/${planId}`)
}
