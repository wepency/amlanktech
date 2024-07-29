import React from "react"

import TicketAttachments from "@/components/dashboard/tickets/attachments"
import OtherTickets from "@/components/dashboard/tickets/other-tickets"
import Ticket from "@/components/dashboard/tickets/ticket"

const page = async () => {
  return (
    <section>
      <div className="flex gap-10">
        <div className="w-full shrink-0 lg:w-2/3">
          <Ticket />
        </div>
        <div className="w-1/3  space-y-8   max-lg:hidden">
          <OtherTickets />
          <TicketAttachments />
        </div>
      </div>
    </section>
  )
}

export default page
