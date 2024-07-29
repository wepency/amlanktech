import { useState } from "react"
import AmlackApi from "@/api"
import {
  Avatar,
  Badge,
  Button,
  Card,
  Divider,
  Group,
  Progress,
  Radio,
  RadioGroup,
  Text,
} from "@mantine/core"
import { useMutation, useQueryClient } from "@tanstack/react-query"
import axios from "axios"

import { Poll } from "@/types/polls-response"

const PollCard = ({ poll }: { poll: Poll }) => {
  const [selectedOption, setSelectedOption] = useState<string | null>(
    poll.selected_option_id + "" || null,
  )
  const queryClient = useQueryClient()

  const voteMutation = useMutation({
    mutationFn: (optionId: string) =>
      AmlackApi.post(`/polls/${poll.id}/toggle-vote`, {
        option_id: optionId,
      }),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["polls"] }) // Invalidate the polls query to refetch the data
    },
  })

  const handleVote = (optionId: string) => {
    setSelectedOption(optionId)
    voteMutation.mutate(optionId)
  }

  return (
    <Card
      shadow="sm"
      padding="lg"
      radius="md"
      className="mb-6 w-full max-w-sm bg-white">
      <Text size="xl" className="mb-2">
        {poll.name}
      </Text>
      <Divider my="sm" />
      <RadioGroup value={selectedOption} onChange={(value) => handleVote(value)}>
        {poll.options.map((option) => (
          <div key={option.id} className="mb-4 space-y-2">
            <div className="flex items-end justify-between">
              <Text>{option.name}</Text>
              {poll.is_answered ? (
                <Badge color={option.is_selected ? "teal" : "gray"}>
                  {option.vote_percent}%
                </Badge>
              ) : null}
            </div>

            <div className="flex items-center gap-2">
              <Radio
                value={String(option.id)}
                checked={selectedOption === option.id + ""}
                disabled={voteMutation.isPending}
              />
              <Progress
                value={poll.is_answered ? option.vote_percent : 0}
                color={option.is_selected ? "teal" : "gray"}
                className=" grow"
              />
            </div>
          </div>
        ))}
      </RadioGroup>
      <Divider my="sm" />
      <Text size="sm" color="dimmed" className="mt-2">
        Created at: {new Date(poll.created_at).toLocaleString()}
      </Text>
    </Card>
  )
}

export default PollCard
