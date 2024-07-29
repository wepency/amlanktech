import React from "react"
import { Group, Paper, SimpleGrid, Text } from "@mantine/core"
import { Icon, IconProps } from "@tabler/icons-react"

export function StatsGrid({
  data,
}: {
  data: {
    title: string
    Icon: React.ForwardRefExoticComponent<
      Omit<IconProps, "ref"> & React.RefAttributes<Icon>
    >
    value: string | number
    des: string
  }[]
}) {
  const stats = data.map((stat) => {
    // const Icon = icons[stat.icon]

    return (
      <Paper
        className="duration-300 hover:-translate-y-2"
        withBorder
        p="md"
        radius="md"
        key={stat.title}>
        <Group justify="space-between">
          <Text size="xs" c="dimmed" className={"text-lg  font-medium uppercase"}>
            {stat.title}
          </Text>
          <stat.Icon className="text-blue-400" size="1.4rem" stroke={1.5} />
        </Group>

        <Group align="flex-end" gap="xs" mt={25}>
          <Text className={"text-xl font-bold"}>{stat.value}</Text>
        </Group>

        <Text fz="xs" c="dimmed" mt={7}>
          {stat.des}
        </Text>
      </Paper>
    )
  })
  return (
    <div>
      <SimpleGrid cols={{ base: 1, xs: 2, md: 4 }}>{stats}</SimpleGrid>
    </div>
  )
}
