import { z } from "zod"

export const AddPermitSchema = z.object({
  association_id: z.string(),
  login_attempts: z
    .string()
    .min(1, "مطلوب")
    .regex(/^\s*\d+\s*$/, "رقم غير صالح"),
  permit_days: z
    .string()
    .min(1, "مطلوب")
    .regex(/^\s*\d+\s*$/, "رقم غير صالح"),
  start_date: z.date(),
  type: z.enum(["maintenance", "worker", "deliver", "visitor"]),
  visitors: z.array(
    z.object({
      national_id: z
        .string()
        .regex(/^\s*\d+\s*$/, "رقم غير صالح")
        .max(10, "رقم غير صالح"),
      visitor_name: z.string().min(1, "مطلوب"),
    }),
  ),
})
