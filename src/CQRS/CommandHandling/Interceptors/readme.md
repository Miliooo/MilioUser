3.5. Command Interceptors

One of the advantages of using a command bus is the ability to undertake action based on all incoming commands. Examples are logging or authentication, which you might want to do regardless of the type of command. This is done using Interceptors.

There are two types of interceptors: Command Dispatch Interceptors and Command Handler Interceptors. The former are invoked before a command is dispatched to a Command Handler. At that point, it may not even be sure that any handler exists for that command. The latter are invoked just before the Command Handler is invoked.
3.5.1. Command Dispatch Interceptors

Command Dispatch Interceptors are invoked when a command is dispatched on a Command Bus. They have the ability to alter the Command Message, by adding Meta Data, for example, or block the command by throwing an Exception. These interceptors are always invoked on the thread that dispatches the Command.
3.5.1.1. Structural validation

There is no point in processing a command if it does not contain all required information in the correct format. In fact, a command that lacks information should be blocked as early as possible, preferably even before any transaction is started. Therefore, an interceptor should check all incoming commands for the availability of such information. This is called structural validation.

Axon Framework has support for JSR 303 Bean Validation based validation. This allows you to annotate the fields on commands with annotations like @NotEmpty and @Pattern. You need to include a JSR 303 implementation (such as Hibernate-Validator) on your classpath. Then, configure a BeanValidationInterceptor on your Command Bus, and it will automatically find and configure your validator implementation. While it uses sensible defaults, you can fine-tune it to your specific needs.
[Tip]	Tip

You want to spend as less resources on an invalid command as possible. Therefore, this interceptor is generally placed in the very front of the interceptor chain. In some cases, a Logging or Auditing interceptor might need to be placed in front, with the validating interceptor immediately following it.

The BeanValidationInterceptor also implements CommandHandlerInterceptor, allowing you to configure it as a Handler Interceptor as well.
3.5.2. Command Handler Interceptors

Command Handler Interceptors can take action both before and after command processing. Interceptors can even block command processing altogether, for example for security reasons.

Interceptors must implement the CommandHandlerInterceptor interface. This interface declares one method, handle, that takes three parameters: the command message, the current UnitOfWork and an InterceptorChain. The InterceptorChain is used to continue the dispatching process.
3.5.2.1. Auditing

Well designed events will give clear insight in what has happened, when and why. To use the event store as an Audit Trail, which provides insight in the exact history of changes in the system, this information might not be enough. In some cases, you might want to know which user caused the change, using what command, from which machine, etc.

The AuditingInterceptor is an interceptor that allows you to attach arbitrary information to events just before they are stored or published. The AuditingInterceptor uses an AuditingDataProvider to retrieve the information to attach to these events. You need to provide the implementation of the AuditingDataProvider yourself.

An Audit Logger may be configured to write to an audit log. To do so, you can implement the AuditLogger interface and configure it in the AuditingInterceptor. The audit logger is notified both on succesful execution of the command, as well as when execution fails. If you use event sourcing, you should be aware that the event log already contains the exact details of each event. In that case, it could suffice to just log the event identifier or aggregate identifier and sequence number combination.
[Note]	Note

Note that the log method is called in the same thread as the command processing. This means that logging to slow sources may result in higher response times for the client. When important, make sure logging is done asynchronously from the command handling thread.
