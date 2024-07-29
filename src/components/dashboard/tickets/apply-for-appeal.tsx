"use client"

import React from "react"
import AmlackApi from "@/api"
import { ActionIcon, rem, Tooltip } from "@mantine/core"
import { notifications } from "@mantine/notifications"
import { IconCheck, IconExclamationCircle, IconX } from "@tabler/icons-react"

import { Ticket } from "@/types/tickets-response"

const ApplyForAppeal = (ticket: Ticket) => {
  const applyForAppeal = async () => {
    const id = notifications.show({
      loading: true,
      title: "عملية جارية",
      message: "جاري رفع شكوى لادارة الجمعية",
      autoClose: false,
      withCloseButton: false,
    })

    try {
      const response = await AmlackApi.post(
        `/support-tickets/${ticket.id}/apply-appeal`,
        {},
      )
      console.log("🚀 ~ applyForAppeal ~ response:", response)
      notifications.update({
        id,
        color: "teal",
        title: "تمت العملية بنجاح",
        message: "تم رفع الشكوى الخاص بك بنجاح",
        icon: <IconCheck style={{ width: rem(18), height: rem(18) }} />,
        loading: false,
        autoClose: 2000,
      })
    } catch (error) {
      console.log("🚀 ~ applyForAppeal ~ error:", error)
      notifications.update({
        id,
        color: "red",
        title: "فشلت العملية",
        message: "فشلت العملية الرجاء المحاولة مجدد",
        icon: <IconX style={{ width: rem(18), height: rem(18) }} />,
        loading: false,
        autoClose: 2000,
      })
    }
  }
  return ticket.can_apply_appeal ? (
    <Tooltip label="رفع شكوى">
      <ActionIcon onClick={applyForAppeal} variant="subtle">
        <IconExclamationCircle
          color="red"
          style={{ width: rem(22), height: rem(22) }}
          stroke={1.5}
        />
      </ActionIcon>
    </Tooltip>
  ) : null
}

export default ApplyForAppeal
