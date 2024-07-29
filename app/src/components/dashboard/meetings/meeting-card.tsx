"use client"

import React from "react"
import Link from "next/link"
import { useParams } from "next/navigation"
import { formatTimeTo12Hour, formatToArabicDate } from "@/utils/formate-date"
import { Badge } from "@mantine/core"
import { IconBrandZoom } from "@tabler/icons-react"

import { Meeting } from "@/types/meetings-response"

type Props = {}

const MeetingCard = ({
  id,
  title,
  date,
  start_time,
  is_started,
  passcode,
  meeting_id,
  created_at,
  current_users,
  description,
}: Meeting) => {
  const { association_id } = useParams() as {
    association_id: string
  }
  return (
    <Link
      href={`/dashboard/${association_id}/meetings/${id}`}
      className="w-full max-w-md ">
      <article className="rounded-xl bg-white p-4 ring ring-Lavender/20 sm:p-6 lg:p-8">
        <div className="flex items-start gap-4 max-sm:flex-col  sm:gap-8">
          <div
            className="grid size-20 shrink-0 place-content-center rounded-full border-2 sm:border-Lavender"
            aria-hidden="true">
            <div className="flex items-center gap-1">
              <IconBrandZoom size={47} className="text-Lavender" stroke={0.5} />
            </div>
          </div>

          <div className="grow">
            <strong className="rounded border border-Lavender bg-Lavender px-3 py-1.5 text-[10px] font-medium text-white">
              code: {meeting_id}
            </strong>

            <h3 className="mt-4 text-lg font-medium sm:text-xl">{title}</h3>

            <p className="mt-1 text-sm text-gray-700">
              {description ? description : `اجتماع مجدول من قبل ادارة الجمعية`}
            </p>

            <div className="mt-4 flex items-center gap-2">
              <div className="flex items-center gap-1 text-gray-500">
                <svg
                  className="h-4 w-4"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>

                <p className="text-xs font-medium">
                  {formatTimeTo12Hour(start_time)}
                </p>
              </div>

              <span className="hidden sm:block" aria-hidden="true">
                &middot;
              </span>

              <p className="mt-2 text-xs font-medium text-gray-500 sm:mt-0">
                {formatToArabicDate(date)}
              </p>
              <span className="hidden sm:block" aria-hidden="true">
                &middot;
              </span>
              <div>
                <Badge
                  color={is_started ? "green" : "violet"}
                  variant="outline"
                  size="sm">
                  {is_started ? "بدا" : "لم يبدأ"}
                </Badge>
              </div>
            </div>
          </div>
        </div>
      </article>
    </Link>
  )
}

export default MeetingCard
