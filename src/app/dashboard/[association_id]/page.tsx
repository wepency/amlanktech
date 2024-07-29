import React from "react"
import { getUserData } from "@/api/helpers/get-me"
import {
  IconBuildingCommunity,
  IconReceipt2,
  IconReport,
  IconUserPlus,
} from "@tabler/icons-react"
import { getServerSession } from "next-auth"

import { authOptions } from "@/lib/next-auth"
import { StatsGrid } from "@/components/ui/status-grid"
import Polls from "@/components/dashboard/polls/polls"
import LastPosts from "@/components/dashboard/posts/last-posts"
import LastRecordsTable from "@/components/table/last-records-table"
import LastRequestsTable from "@/components/table/last-requests-table"

const dummyApplicationsData = [
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
  {
    id: 0,
    subject: "عنوان للطلب",
    date: "10/2/2024",
    status: "progress",
    actions: [{ icon: "eye" }],
  },
]
type Props = {}

const page = async (props: Props) => {
  const session = (await getServerSession(authOptions))!
  const user = await getUserData()
  const [associations, units, tickets, subscriptions, awaitingSubscriptions] = [
    user.data.statics?.associations || 0,
    user.data.statics?.units || 0,
    user.data.statics?.tickets || 0,
    user.data.statics?.subscriptions || 0,
    user.data.statics?.awaiting_subscriptions || 0,
  ]
  const data = [
    {
      title: "الجمعيات",
      Icon: IconUserPlus,
      value: associations,
      des: `انت عضو في ${associations} جمعيات`,
    },
    {
      title: "الوحدات",
      Icon: IconBuildingCommunity,
      value: units,
      des: units ? `عدد الوحدات الخاص بك هو ${units}` : "لا يوجد اي وحدات حتى الان",
    },
    {
      title: "اشتراكات بانتظار الدفع",
      Icon: IconReceipt2,
      value: awaitingSubscriptions,
      des: awaitingSubscriptions
        ? ` ${awaitingSubscriptions} اشتراكات بانتظار الدفع`
        : "لا يوجد اي اشتراكات بانتظار الدفع",
    },
    { title: "الطلبات", Icon: IconReport, value: tickets, des: "الطلبات الخاصة بك" },
    {
      title: "الاشتراكات",
      Icon: IconReceipt2,
      value: subscriptions,
      des: "الاشتراكات الخاصة بك",
    },
  ]
  return (
    <section>
      <div className="space-y-6">
        <StatsGrid data={data} />
        <div className="  py-4">
          <h2 className="mb-4">أخر المنشورات</h2>
          <div className="flex gap-4 max-md:flex-wrap">
            <LastPosts />
          </div>
        </div>
        <div className="  py-4">
          <h2 className="mb-4">استطلاعات الرأي</h2>
          <div className="flex gap-4 max-md:flex-wrap">
            <Polls />
          </div>
        </div>
        <div className="flex gap-5 py-4  max-lg:flex-wrap ">
          <div className="w-full rounded-lg bg-white p-3 lg:w-1/2">
            <p className="py-3">اخر السجلات</p>
            <LastRecordsTable data={dummyApplicationsData} />
          </div>
          <div className="w-full rounded-lg bg-white p-3 lg:w-1/2">
            <p className="py-3">طلبات قيد المراجعة</p>
            <LastRequestsTable data={dummyApplicationsData} />
          </div>
        </div>
      </div>
    </section>
  )
}

export default page
