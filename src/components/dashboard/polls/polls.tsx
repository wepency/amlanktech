"use client"

import { useParams } from "next/navigation"
import { getPolls } from "@/api/helpers/get-polls"
import { Loader } from "@mantine/core"
import { useQuery } from "@tanstack/react-query"

import PollCard from "./poll-card"

type Props = { token: string }

const Polls = () => {
  const { association_id } = useParams() as { association_id: string }
  const { data, error, isLoading } = useQuery({
    queryKey: ["polls", association_id],
    queryFn: async () => {
      return await getPolls({ association_id })
    },
  })
  if (isLoading)
    return (
      <div className="flex h-[350px] grow items-center justify-center">
        <Loader size={"lg"} />
      </div>
    )
  return (
    <>
      <div className="flex grow flex-wrap gap-8 ">
        {data?.data.polls.map((poll) => <PollCard key={poll.id} poll={poll} />)}
      </div>
    </>
  )
}

export default Polls
