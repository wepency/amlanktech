import { useState } from "react"
import AmlackApi from "@/api"
import {
  ActionIcon,
  Avatar,
  Badge,
  Card,
  Divider,
  Group,
  Modal,
  Progress,
  Radio,
  RadioGroup,
  ScrollArea,
  SegmentedControl,
  Tabs,
  Text,
} from "@mantine/core"
import { useDisclosure } from "@mantine/hooks"
import { IconEye } from "@tabler/icons-react"
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
    if (selectedOption) return
    setSelectedOption(optionId)
    voteMutation.mutate(optionId)
  }

  const [opened, { open, close }] = useDisclosure(false)

  return (
    <>
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
        <div className="flex justify-between">
          <Text size="sm" color="dimmed" className="mt-2">
            Created at: {new Date(poll.created_at).toLocaleString()}
          </Text>
          <div>
            <ActionIcon onClick={open} variant="subtle">
              <IconEye />
            </ActionIcon>
          </div>
        </div>
      </Card>
      <Modal centered size={"lg"} opened={opened} onClose={close} title="المصوتين">
        <Tabs defaultValue={poll.options[0].id + ""}>
          <Tabs.List>
            {poll.options.map((option) => (
              <Tabs.Tab key={option.id} value={option.id + ""}>
                {option.name}
              </Tabs.Tab>
            ))}
          </Tabs.List>
          {poll.options.map((option) => (
            <Tabs.Panel key={option.id} value={option.id + ""}>
              <ScrollArea type="never" h={"calc(100vh - 260px)"} pt={20} pb={20}>
                <div className="space-y-6">
                  {option.votes.map((vote) => (
                    <div
                      key={"vote_" + vote.name + vote.id}
                      className=" flex w-full gap-3 text-sm ">
                      <Avatar src={vote.avatar} size={"sm"} radius="xl" />
                      <div>
                        <p className="mb-2  font-medium">{vote.name || "مجهول"}</p>
                      </div>
                    </div>
                  ))}
                </div>
              </ScrollArea>
            </Tabs.Panel>
          ))}
        </Tabs>
      </Modal>
    </>
  )
}

export default PollCard
