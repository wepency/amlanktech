"use client"

import React, { ElementRef, useEffect, useRef, useState } from "react"
import { addComment } from "@/api/helpers/add-comment"
import { updateReaction } from "@/api/helpers/update-reaction"
import { cn } from "@/utils/cn"
import {
  Avatar,
  Button,
  Center,
  Group,
  Modal,
  ScrollArea,
  Text,
  Textarea,
} from "@mantine/core"
import { useDisclosure } from "@mantine/hooks"
import { notifications } from "@mantine/notifications"
import {
  IconSend2,
  IconThumbDownFilled,
  IconThumbUpFilled,
} from "@tabler/icons-react"
import { useQueryClient } from "@tanstack/react-query"
import { useSession } from "next-auth/react"

import { Comment, Post } from "@/types/posts-response"

type Props = {}

const PostCard = ({
  id,
  image,
  since,
  comments,
  content,
  likes,
  dislikes,
  my_reaction,
}: Post) => {
  const queryClient = useQueryClient()
  const { data } = useSession()
  const [addedComments, setAddedComments] = useState<
    (Comment & { isLoading?: boolean; isError?: boolean })[]
  >([])
  const lasMessageRef = useRef<ElementRef<"div">>(null)

  const scrollToBottom = () => {
    if (lasMessageRef.current) {
      lasMessageRef.current!.scrollIntoView({ behavior: "smooth" })
    }
  }
  useEffect(scrollToBottom, [addedComments.length])
  // modal state
  const [opened, { open, close }] = useDisclosure(false)
  // comment state
  const [comment, setComment] = useState("")

  // handling adding a new comment
  const handleSubmit: React.FormEventHandler<HTMLFormElement> = async (e) => {
    e.preventDefault()

    const commentID = (Math.random() * 1000).toFixed()

    const commentValue = comment
    try {
      const newComment = {
        id: commentID,
        comment: commentValue,
        since: "الآن",
        isLoading: true,
        user: {
          id: Math.floor(Math.random() * 100),
          name: data?.user.user.name || "",
          image: data?.user.user.avatar || "",
        },
      }
      setAddedComments((pre) => {
        return [...pre, newComment]
      })
      setComment("")

      const response = await addComment({
        postID: id,
        comment: commentValue,
      })
      setAddedComments((pre) => {
        return pre.map((e) =>
          e.id === commentID ? { ...e, isError: false, isLoading: false } : e,
        )
      })
    } catch (error) {
      setAddedComments((pre) => {
        return pre.map((e) =>
          e.id === commentID ? { ...e, isError: true, isLoading: false } : e,
        )
      })
    }
  }

  const [isLoadingReactionChange, setIsLoadingReactionChange] = useState(false)
  const handleReaction = async (reaction: "like" | "dislike") => {
    try {
      setIsLoadingReactionChange(true)
      const response = await updateReaction({
        postID: id,
        type: reaction === my_reaction ? null : reaction,
      })
      await Promise.all([
        await queryClient.invalidateQueries({ queryKey: ["posts"] }),
        await queryClient.invalidateQueries({ queryKey: ["last-posts"] }),
      ])
    } catch (error) {
      notifications.show({
        title: "فشلت العملية!",
        message: "لم نتمكن من تعديل التفاعل الخاص بك, الرجاء الحاولة مجداً",
        color: "red",
      })
    } finally {
      setIsLoadingReactionChange(false)
    }
  }
  return (
    <>
      <article
        onClick={open}
        className=" group relative   max-w-xs  cursor-pointer overflow-hidden rounded-lg shadow transition hover:shadow-lg">
        <img
          alt="id"
          src={image}
          className="absolute inset-0 h-full w-full object-cover duration-300 group-hover:opacity-70"
        />
        <div
          className={cn(
            "  absolute right-4 top-4 z-10 flex cursor-pointer gap-3 text-center text-sm ",
            isLoadingReactionChange ? "pointer-events-none opacity-35 " : "",
          )}
          onClick={(e) => e.stopPropagation()}>
          <div>
            <IconThumbDownFilled
              onClick={(e) => {
                handleReaction("dislike")
              }}
              className={cn(
                my_reaction === "dislike" ? "text-Primary" : "text-Gray",
              )}
              size={20}
            />
            <span>{dislikes}</span>
          </div>
          <div>
            <IconThumbUpFilled
              onClick={(e) => {
                handleReaction("like")
              }}
              className={cn(my_reaction === "like" ? "text-Primary" : "text-Gray")}
              size={20}
            />
            {likes}
          </div>
        </div>
        <div className="relative bg-gradient-to-t from-gray-900/50 to-gray-900/25 pt-28  lg:pt-44">
          <div className="p-4  sm:p-6">
            <Group
              className="mb-3 text-white/90 duration-300 group-hover:-translate-y-3"
              gap="lg">
              <Center>
                <Text size="xs">{since}</Text>
              </Center>
            </Group>
            <div
              dangerouslySetInnerHTML={{ __html: content }}
              className="mt-2 line-clamp-5 text-sm/relaxed text-white/95 duration-300 group-hover:-translate-y-2"></div>
          </div>
        </div>
      </article>
      <Modal
        size="calc(100vw - 3rem)"
        opened={opened}
        onClose={close}
        title="المنشور">
        <div className="flex gap-8  max-lg:flex-col-reverse">
          <div className="lg:w-1/2 ">
            <p className="bg-white px-3 py-3 text-lg font-semibold shadow">
              التعليقات
            </p>
            <ScrollArea type="never" h={"calc(100vh - 260px)"} pt={20} pb={20}>
              <div className="space-y-6">
                {comments.map((comment, index) => {
                  return (
                    <div
                      key={`comments_${comment.id}`}
                      className=" flex w-full gap-3 text-sm ">
                      <Avatar src={comment.user?.image} size={"sm"} radius="xl" />
                      <div>
                        <p className="mb-2  font-medium">
                          {comment?.user?.name || "مجهول"}
                        </p>
                        <p className=" font-light text-[#878787] ">
                          {comment.comment}
                        </p>
                      </div>
                      <span className="mr-auto block shrink-0 text-xs">
                        {comment.since}
                      </span>
                    </div>
                  )
                })}
                {addedComments.map((comment, index) => {
                  return (
                    <div
                      ref={index === addedComments.length - 1 ? lasMessageRef : null}
                      key={`comments_${comment.id}`}
                      className=" flex w-full gap-3 text-sm ">
                      <Avatar src={comment.user?.image} size={"sm"} radius="xl" />
                      <div>
                        <p className="mb-2  font-medium">
                          {comment?.user?.name || "مجهول"}
                        </p>
                        <p className=" font-light text-[#878787] ">
                          {comment.comment}
                        </p>
                      </div>
                      <span
                        className={`mr-auto block shrink-0 text-xs ${comment.isError ? " text-red-600" : ""}`}>
                        {comment.isLoading
                          ? "جاري النشر"
                          : comment.isError
                            ? "لم يتم النشر"
                            : comment.since}
                      </span>
                    </div>
                  )
                })}
              </div>
            </ScrollArea>
            <form onSubmit={handleSubmit} className="flex items-center gap-3">
              <Textarea
                value={comment}
                onChange={(e) => setComment(e.target.value)}
                className="w-full"
                placeholder="تعليقك"
                required
              />
              <Button onClick={scrollToBottom} type="submit" variant="white">
                <IconSend2 size={"xl"} className=" rotate-180" stroke={1.5} />
              </Button>
            </form>
          </div>
          <div className="lg:w-1/2">
            <ScrollArea type="never" h={"calc(100vh - 150px)"} pt={20}>
              <div>
                <div>
                  <img
                    src={image}
                    alt="post image"
                    className="mx-auto max-w-[50%]"
                  />
                </div>
                <div
                  dangerouslySetInnerHTML={{
                    __html: content,
                  }}
                  className="my-4"></div>
              </div>
            </ScrollArea>
          </div>
        </div>
      </Modal>
    </>
  )
}

export default PostCard
