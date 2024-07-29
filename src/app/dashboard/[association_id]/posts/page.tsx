import React from "react"

import Posts from "@/components/dashboard/posts/all-posts"

const Page = async () => {
  return (
    <div className=" min-h-[calc(100vh-100px)] rounded-lg border bg-white  px-4 py-6 pb-10 shadow">
      <h1 className="mb-10 text-xl font-bold">جميع المنشورات</h1>
      <Posts />
    </div>
  )
}

export default Page
