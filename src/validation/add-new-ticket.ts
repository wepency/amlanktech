import { z } from "zod"

export const AddNewTicketSchema = z.object({
  association_id: z.string(),
  category_id: z.string(),
  unit_id: z.string(),
  subject: z.string().min(3, "عنوان الطلب قصير للغاية"),
  body: z
    .string()
    .min(50, "الرجاء كتابة تفاصيل الطلب بعناية حيث لا يقل موضوع الطلب عن 50 حرفاً"),
  importance: z.enum(["normal", "average", "urgent"]),
})
