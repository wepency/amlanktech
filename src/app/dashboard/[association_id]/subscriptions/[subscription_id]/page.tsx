import React from "react"
import AmlackApi from "@/api"

type Props = {
  params: {
    association_id: string
    subscription_id: string
  }
}

const page = async ({ params: { subscription_id } }: Props) => {
  const subscription = (await AmlackApi.get(
    `subscriptions/${subscription_id}`,
  )) as string
  return (
    <section>
      <div className="min-h-[calc(100vh-130px)] rounded-lg border bg-white px-4 py-6   shadow">
        <div dangerouslySetInnerHTML={{ __html: subscription }}></div>
      </div>
    </section>
  )
}

export default page
