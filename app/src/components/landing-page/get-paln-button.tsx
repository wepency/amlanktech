"use client"

import React from "react"
import { PostPlan } from "@/api/helpers/post-plan"
import { Button } from "@mantine/core"
import { useMutation } from "@tanstack/react-query"

type Props = {
  planId: string
}

const GetPlanButton = ({ planId }: Props) => {
  const { mutate } = useMutation({
    mutationFn: () => PostPlan(planId),
    onSuccess(data, variables, context) {},
  })
  return (
    <Button className="mt-8 w-full" variant="outline">
      اشترك الآن
    </Button>
  )
}

export default GetPlanButton
