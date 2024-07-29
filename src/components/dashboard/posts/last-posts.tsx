"use client"

import React from "react"
import { useParams } from "next/navigation"
import { getPosts } from "@/api/helpers/get-posts"
import { Loader } from "@mantine/core"
import { useQuery } from "@tanstack/react-query"

import { PostsResponse } from "@/types/posts-response"
import Error from "@/components/ui/error"
import PostCard from "@/components/ui/post-card"

const LastPosts = () => {
  const { association_id } = useParams() as {
    association_id: string
  }
  const { data, isFetching, isLoading, error } = useQuery<PostsResponse>({
    queryKey: ["last-posts", association_id],
    queryFn: async () => {
      return await getPosts({
        pageParam: "1",
        association_id,
      })
    },
  })

  if (isLoading)
    return (
      <div className="flex h-[300px] w-full  items-center justify-center">
        <Loader size={"lg"} />
      </div>
    )
  if (error)
    return <Error message=" عذرا ,لم نتمكن من عرض المنشورات لديك " error={error} />

  if (!isFetching && data?.data.posts.length === 0) {
    return <p className="py-5 text-center">لا يوجد اي منشورات حاليا</p>
  }

  return (
    <div className="flex gap-5 ">
      {data?.data.posts?.slice(0, 4).map((post) => {
        return <PostCard key={post.id} {...post} />
      })}
    </div>
  )
}

export default LastPosts
