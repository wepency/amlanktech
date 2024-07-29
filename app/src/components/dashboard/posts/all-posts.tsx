"use client"

import React, { useRef } from "react"
import { getPosts } from "@/api/helpers/get-posts"
import { Loader } from "@mantine/core"

import { PostsResponse } from "@/types/posts-response"
import useInfiniteQuery from "@/hooks/use-infinite-query"
import Error from "@/components/ui/error"
import PostCard from "@/components/ui/post-card"

type Props = { token: string }

const Posts = () => {
  const ref = useRef<React.ElementRef<"div">>(null)
  const { error, data, isFetching, isFetchingNextPage, isLoading } =
    useInfiniteQuery<PostsResponse>({
      queryKey: ["posts"],
      fetcher: getPosts,
      ref: ref,
    })

  if (isLoading)
    return (
      <div className="flex h-[calc(100vh-240px)] w-full  items-center justify-center">
        <Loader size={"lg"} />
      </div>
    )
  if (error)
    return <Error message=" عذرا ,لم نتمكن من عرض المنشورات لديك " error={error} />

  if (!isLoading && data?.pages.flatMap((e) => e.data?.posts).length === 0) {
    return <p className="py-5 text-center">لا يوجد اي منشورات حاليا</p>
  }

  const posts = data?.pages!.flatMap((element) => element.data.posts)
  return (
    <>
      <div className="flex flex-wrap gap-5 ">
        {posts?.map((post) => {
          return <PostCard key={post.id} {...post} />
        })}
      </div>
      {isFetchingNextPage && (
        <div className="flex items-center justify-center py-10">
          <Loader />
        </div>
      )}
      <div className="h-5 " ref={ref}></div>
    </>
  )
}

export default Posts
